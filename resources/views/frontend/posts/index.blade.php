@extends('frontend.layouts.master')

@section('title', 'Blog Posts')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="mb-3">
            @isset($category)
                Posts in Category: {{ $category->name }}
                @isset($subcategory)
                    > {{ $subcategory->name }}
                @endisset
            @else
                Latest Blog Posts
            @endisset
        </h1>
    </div>
</div>

<div class="row">
    @forelse($posts as $post)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text text-muted small">
                        Posted in 
                        @isset($post->category)
    <a href="{{ route('posts.byCategory', $post->category) }}">{{ $post->category->name }}</a>
    @isset($post->subcategory)
        > <a href="{{ route('posts.bySubcategory', [$post->category, $post->subcategory]) }}">{{ $post->subcategory->name }}</a>
    @endisset
@endisset
                    </p>
                    <p class="card-text">{{ Str::limit($post->content, 150) }}</p>
                    <a href="{{ route('front.posts.show', $post) }}" class="btn btn-primary">Read More</a>
                </div>
                <div class="card-footer text-muted small">
                    {{ $post->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">No posts found.</div>
        </div>
    @endforelse
</div>

@if($posts->hasPages())
    <div class="row">
        <div class="col-12">
            {{ $posts->links() }}
        </div>
    </div>
@endif
@endsection