@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Subcategories</h2>

    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <a href="{{ route('subcategories.create') }}">Create Subcategory</a>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subcategories as $subcategory)
                <tr>
                    <td>{{ $subcategory->name }}</td>
                    <td>{{ $subcategory->category->name }}</td>
                    <td>
                        <a href="{{ route('subcategories.edit', $subcategory) }}">Edit</a> |
                        <form action="{{ route('subcategories.destroy', $subcategory) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="3">No subcategories found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
