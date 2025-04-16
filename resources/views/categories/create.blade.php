@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Category</h2>

    @if ($errors->any())
        <div>
            <ul style="color: red;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <label for="name">Category Name:</label>
        <input type="text" name="name" value="{{ old('name') }}" required>
        <button type="submit">Create</button>
    </form>

    <a href="{{ route('categories.index') }}">← Back</a>
</div>
@endsection
