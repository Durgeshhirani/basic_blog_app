@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Subcategory</h2>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('subcategories.update', $subcategory) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Subcategory Name:</label>
            <input type="text" name="name" value="{{ old('name', $subcategory->name) }}" required>
        </div>

        <div>
            <label>Select Category:</label>
            <select name="category_id" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $subcategory->category_id) == $category->id)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit">Update</button>
    </form>
</div>
@endsection
