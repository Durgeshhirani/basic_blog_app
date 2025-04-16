@extends('frontend.layouts.master')

@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <article>
            <h1 class="mb-3">{{ $post->title }}</h1>
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="text-muted">
                @isset($post->category)
    <span>Posted in </span>
    <a href="{{ route('posts.byCategory', $post->category) }}">{{ $post->category->name }}</a>
    @isset($post->subcategory)
        <span> > </span>
        <a href="{{ route('posts.bySubcategory', [$post->category, $post->subcategory]) }}">{{ $post->subcategory->name }}</a>
    @endisset
    <span> • {{ $post->created_at->diffForHumans() }}</span>
@endisset
                </div>
                
                @auth
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                @endauth
            </div>
            
            <div class="post-content mb-5">
                {!! nl2br(e($post->content)) !!}
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('front.home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Back to Posts
                </a>
                
                @auth
                    <form action="{{ route('posts.destroy', $post) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                @endauth
            </div>
        </article>
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5>About the Author</h5>
            </div>
            <div class="card-body">
                <p>This is a placeholder for author information. You can customize this section as needed.</p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h5>Related Posts</h5>
            </div>
            <div class="card-body">
                @php
                    $relatedPosts = App\Models\Post::where('category_id', $post->category_id)
                        ->where('id', '!=', $post->id)
                        ->latest()
                        ->limit(3)
                        ->get();
                @endphp
                
                @if($relatedPosts->count())
                    <ul class="list-group list-group-flush">
                        @foreach($relatedPosts as $related)
                            <li class="list-group-item">
                                <a href="{{ route('front.posts.show', $related) }}">{{ $related->title }}</a>
                                <small class="text-muted d-block">{{ $related->created_at->diffForHumans() }}</small>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No related posts found.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection