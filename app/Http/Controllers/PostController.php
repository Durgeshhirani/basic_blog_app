<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /*
     * FRONTEND METHODS (Public Access)
     */

    /**
     * Display homepage with all posts
     */
    public function index()
    {
        $posts = Post::with(['category', 'subcategory'])
            ->latest()
            ->paginate(10);

        return view('frontend.posts.index', compact('posts'));
    }

    /**
     * Display single post
     */
    public function show(Post $post)
    {
        $post->load(['category', 'subcategory']);
        return view('frontend.posts.show', compact('post'));
    }

    /**
     * Filter posts by category
     */
    public function filterByCategory(Category $category)
    {
        $posts = Post::where('category_id', $category->id)
            ->with(['category', 'subcategory'])
            ->latest()
            ->paginate(10);

        return view('frontend.posts.index', compact('posts', 'category'));
    }

    /**
     * Filter posts by subcategory
     */
    public function filterBySubcategory(Category $category, Subcategory $subcategory)
    {
        // Validate category-subcategory relationship
        if ($subcategory->category_id !== $category->id) {
            abort(404);
        }

        $posts = Post::where('category_id', $category->id)
            ->where('subcategory_id', $subcategory->id)
            ->with(['category', 'subcategory'])
            ->latest()
            ->paginate(10);

        return view('frontend.posts.index', compact('posts', 'category', 'subcategory'));
    }

    /*
     * ADMIN METHODS (Authenticated Access Only)
     */

    /**
     * Display all posts in admin panel
     */
    public function adminIndex()
    {
        $posts = Post::with(['category', 'subcategory'])
            ->latest()
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show post creation form
     */
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();

        return view('admin.posts.create', compact('categories', 'subcategories'));
    }

    /**
     * Store new post
     */
    public function store(Request $request)
    {
        $validated = $this->validatePostRequest($request);

        Post::create($validated);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Show post edit form
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $subcategories = Subcategory::where('category_id', $post->category_id)->get();

        return view('admin.posts.edit', compact('post', 'categories', 'subcategories'));
    }

    /**
     * Update existing post
     */
    public function update(Request $request, Post $post)
    {
        $validated = $this->validatePostRequest($request, $post);

        $post->update($validated);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post updated successfully.');
    }

    /**
     * Delete post
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }

    /*
     * AJAX METHODS
     */

    /**
     * Get subcategories by category (AJAX)
     */
    public function getSubcategories(Request $request)
    {
        $subcategories = Subcategory::where('category_id', $request->category_id)
            ->get();

        return response()->json($subcategories);
    }

    /*
     * PRIVATE HELPER METHODS
     */

    /**
     * Validate post request data
     */
    private function validatePostRequest(Request $request, ?Post $post = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => [
                'nullable',
                'exists:subcategories,id',
                function ($attribute, $value, $fail) use ($request, $post) {
                    $exists = Subcategory::where('id', $value)
                        ->where('category_id', $request->category_id);

                    if ($post) {
                        $exists->where('id', '!=', $post->id);
                    }

                    if (!$exists->exists()) {
                        $fail('The selected subcategory does not belong to this category.');
                    }
                }
            ],
        ]);
    }
}
