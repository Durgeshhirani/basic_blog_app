@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Categories</h5>
                        <h2 class="card-text">{{ $categoriesCount }}</h2>
                    </div>
                    <i class="fas fa-list fa-3x"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('categories.index') }}" class="text-white">View all <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Subcategories</h5>
                        <h2 class="card-text">{{ $subcategoriesCount }}</h2>
                    </div>
                    <i class="fas fa-list-alt fa-3x"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('subcategories.index') }}" class="text-white">View all <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Posts</h5>
                        <h2 class="card-text">{{ $postsCount }}</h2>
                    </div>
                    <i class="fas fa-newspaper fa-3x"></i>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('posts.index') }}" class="text-white">View all <i class="fas fa-arrow-right ms-1"></i></a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5>Recent Posts</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPosts as $post)
                        <tr>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->category->name }}</td>
                            <td>{{ $post->subcategory->name }}</td>
                            <td>{{ $post->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No posts found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection