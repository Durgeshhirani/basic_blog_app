@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Category</h2>

    @if ($errors->any())
        <div>
            <ul style="color: red;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Category Name:</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" required>
        <button type="submit">Update</button>
    </form>

    <a href="{{ route('categories.index') }}">← Back</a>
</div>
@endsection
