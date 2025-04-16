@extends('admin.layouts.master')

@section('title', 'Subcategories')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Subcategories List</h5>
        <a href="{{ route('subcategories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Create New Subcategory
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Posts</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subcategories as $subcategory)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $subcategory->name }}</td>
                            <td>{{ $subcategory->category->name }}</td>
                            <td>{{ $subcategory->posts_count }}</td>
                            <td>{{ $subcategory->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('subcategories.edit', $subcategory->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('subcategories.destroy', $subcategory->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No subcategories found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection