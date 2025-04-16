@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Categories</h2>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <a href="{{ route('categories.create') }}">➕ Add Category</a>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}">✏️ Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this category?')">🗑️ Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4">No categories found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
