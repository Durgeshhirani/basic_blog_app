@extends('layouts.app')
@section('content')
<h2>{{ isset($blog) ? 'Edit' : 'Create' }} Blog Post</h2>
<form method="POST" action="{{ isset($blog) ? route('blogs.update', $blog->id) : route('blogs.store') }}">
    @csrf
    @if(isset($blog)) @method('PUT') @endif
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" class="form-control" name="title" value="{{ old('title', $blog->title ?? '') }}">
    </div>
    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea class="form-control" name="content" rows="5">{{ old('content', $blog->content ?? '') }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="category_id" id="category-dropdown" class="form-select">
            <option>Select Category</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Subcategory</label>
        <select name="subcategory_id" id="subcategory-dropdown" class="form-select">
            @if(isset($subcategories))
                @foreach($subcategories as $sub)
                    <option value="{{ $sub->id }}" {{ old('subcategory_id', $blog->subcategory_id ?? '') == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                @endforeach
            @endif
        </select>
    </div>
    <button type="submit" class="btn btn-success">{{ isset($blog) ? 'Update' : 'Create' }}</button>
</form>
<script>
document.getElementById('category-dropdown').addEventListener('change', function () {
    fetch('/get-subcategories/' + this.value)
        .then(response => response.json())
        .then(data => {
            const subDropdown = document.getElementById('subcategory-dropdown');
            subDropdown.innerHTML = '';
            data.forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.id;
                option.text = sub.name;
                subDropdown.add(option);
            });
        });
});
</script>
@endsection
