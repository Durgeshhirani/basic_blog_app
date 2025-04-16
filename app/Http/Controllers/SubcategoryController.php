<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of subcategories.
     */
    public function index()
    {
        $subcategories = Subcategory::with(['category', 'posts'])
            ->withCount('posts')
            ->latest()
            ->get();

        return view('admin.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new subcategory.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created subcategory.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($request) {
                    if (Subcategory::where('name', $value)
                            ->where('category_id', $request->category_id)
                            ->exists()) {
                        $fail('The subcategory name must be unique within the selected category.');
                    }
                },
            ],
            'category_id' => 'required|exists:categories,id',
        ]);

        Subcategory::create($validated);

        return redirect()
            ->route('subcategories.index')
            ->with('success', 'Subcategory created successfully.');
    }

    /**
     * Show the form for editing the specified subcategory.
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified subcategory.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'max:255',
                function ($attribute, $value, $fail) use ($request, $subcategory) {
                    if (Subcategory::where('name', $value)
                            ->where('category_id', $request->category_id)
                            ->where('id', '!=', $subcategory->id)
                            ->exists()) {
                        $fail('The subcategory name must be unique within the selected category.');
                    }
                },
            ],
            'category_id' => 'required|exists:categories,id',
        ]);

        $subcategory->update($validated);

        return redirect()
            ->route('subcategories.index')
            ->with('success', 'Subcategory updated successfully.');
    }

    /**
     * Remove the specified subcategory.
     */
    public function destroy(Subcategory $subcategory)
    {
        // Check if subcategory has posts
        if ($subcategory->posts()->exists()) {
            return redirect()
                ->route('subcategories.index')
                ->with('error', 'Cannot delete subcategory with existing posts.');
        }

        $subcategory->delete();

        return redirect()
            ->route('subcategories.index')
            ->with('success', 'Subcategory deleted successfully.');
    }
}
