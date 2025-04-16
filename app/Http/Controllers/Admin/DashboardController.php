<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Subcategory;

class DashboardController extends Controller
{
    public function index()
    {
        $categoriesCount = Category::count();
        $subcategoriesCount = Subcategory::count();
        $postsCount = Post::count();
        $recentPosts = Post::with(['category', 'subcategory'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.home', compact(
            'categoriesCount',
            'subcategoriesCount',
            'postsCount',
            'recentPosts'
        ));
    }
}
