<?php

// use App\Http\Controllers\Admin\AdminController;
// use App\Http\Controllers\Admin\DashboardController;
// use App\Http\Controllers\CategoryController;
// use App\Http\Controllers\PostController;
// use App\Http\Controllers\SubcategoryController;
// use Illuminate\Support\Facades\Route;

// // Frontend Routes
// Route::get('/', [PostController::class, 'index'])->name('front.home');
// Route::get('/posts/{post}', [PostController::class, 'show'])->name('front.posts.show');
// Route::get('/category/{category}', [PostController::class, 'filterByCategory'])->name('posts.byCategory');
// Route::get('/category/{category}/subcategory/{subcategory}', [PostController::class, 'filterBySubcategory'])->name('posts.bySubcategory');

// // Authentication Routes
// Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
// Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// // Admin Routes
// Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

//     // Admin Management
//     Route::get('/admins', [AdminController::class, 'index'])->name('admin.admins.index');
//     Route::get('/admins/create', [AdminController::class, 'create'])->name('admin.admins.create');
//     Route::post('/admins', [AdminController::class, 'store'])->name('admin.admins.store');
//     Route::delete('/admins/{user}', [AdminController::class, 'destroy'])->name('admin.admins.destroy');

//     // Resource Routes
//     Route::resource('categories', CategoryController::class)->except(['show']);
//     Route::resource('subcategories', SubcategoryController::class)->except(['show']);
//     Route::resource('posts', PostController::class)->except(['show']);

//     // AJAX Route
//     Route::get('/subcategories-by-category', [PostController::class, 'getSubcategories'])
//         ->name('admin.subcategories.byCategory');
// });

// // Home Route
// Route::get('/home', function () {
//     return redirect()->route('admin.dashboard');
// })->name('home');

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Frontend Routes (Public Access)
 * |--------------------------------------------------------------------------
 */
Route::get('/', [PostController::class, 'index'])->name('front.home');
Route::get('/posts/{post}', [PostController::class, 'show'])->name('front.posts.show');
Route::get('/category/{category}', [PostController::class, 'filterByCategory'])
    ->name('posts.byCategory');
Route::get('/category/{category}/subcategory/{subcategory}', [PostController::class, 'filterBySubcategory'])
    ->name('posts.bySubcategory');

/*
 * |--------------------------------------------------------------------------
 * | Authentication Routes (Public Access)
 * |--------------------------------------------------------------------------
 */
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->name('logout');
});

/*
 * |--------------------------------------------------------------------------
 * | Admin Routes (Authenticated Admins Only)
 * |--------------------------------------------------------------------------
 */
Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Admin Management
    Route::get('/admin/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('/admin/admins/create', [AdminController::class, 'create'])->name('admins.create');
    Route::post('/admin/admins', [AdminController::class, 'store'])->name('admins.store');
    Route::get('/admin/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admins.edit');
    Route::put('/admin/admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
    Route::delete('/admin/admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy');

    // Categories
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/admin/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/admin/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/admin/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Subcategories
    Route::get('/admin/subcategories', [SubcategoryController::class, 'index'])->name('subcategories.index');
    Route::get('/admin/subcategories/create', [SubcategoryController::class, 'create'])->name('subcategories.create');
    Route::post('/admin/subcategories', [SubcategoryController::class, 'store'])->name('subcategories.store');
    Route::get('/admin/subcategories/{subcategory}/edit', [SubcategoryController::class, 'edit'])->name('subcategories.edit');
    Route::put('/admin/subcategories/{subcategory}', [SubcategoryController::class, 'update'])->name('subcategories.update');
    Route::delete('/admin/subcategories/{subcategory}', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy');

    // Posts
    Route::get('/admin/posts', [PostController::class, 'adminIndex'])->name('posts.index');
    Route::get('/admin/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/admin/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/admin/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/admin/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/admin/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // AJAX Route
    Route::get('/admin/subcategories-by-category', [PostController::class, 'getSubcategories'])
        ->name('subcategories.byCategory');
});

/*
 * |--------------------------------------------------------------------------
 * | Home Route Redirect (After Login)
 * |--------------------------------------------------------------------------
 */
Route::get('/home', function () {
    return redirect()->route('dashboard');
})->name('home');
