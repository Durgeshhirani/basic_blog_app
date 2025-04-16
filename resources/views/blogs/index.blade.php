@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h2>All Blog Posts</h2>
    <a href="{{ route('blogs.create') }}" class="btn btn-primary">Create Blog</a>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Title</th><th>Category</th><th>Subcategory</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($blogs as $blog)
    <tr>
        <td>{{ $blog->title }}</td>
        <td>{{ $blog->category->name }}</td>
        <td>{{ $blog->subcategory->name }}</td>
        <td>
            <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-sm btn-warning">Edit</a>
            <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection