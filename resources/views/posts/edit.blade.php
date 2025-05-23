@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Post</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Title</label>
                <input type="text" name="title" class="form-control" value="{{ $post->title }}">
            </div>

            <div class="mb-3">
                <label>Content</label>
                <textarea name="content" class="form-control" rows="5">{{ $post->content }}</textarea>
            </div>

            <div class="mb-3">
                <label>Category</label>
                <select name="category_id" id="category" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Subcategory</label>
                <select name="subcategory_id" id="subcategory" class="form-control">
                    <option value="">Select Subcategory</option>
                    @foreach($subcategories as $subcategory)
                        <option value="{{ $subcategory->id }}" {{ $subcategory->id == $post->subcategory_id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection

@section('scripts')
<script>
    document.getElementById('category').addEventListener('change', function() {
        const categoryId = this.value;
        fetch(`/subcategories-by-category/${categoryId}`)
            .then(response => response.json())
            .then(data => {
                const subcategory = document.getElementById('subcategory');
                subcategory.innerHTML = '<option value="">Select Subcategory</option>';
                data.forEach(sub => {
                    subcategory.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                });
            });
    });
</script>
@endsection