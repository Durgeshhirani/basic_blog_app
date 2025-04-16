@extends('admin.layouts.master')

@section('title', 'Edit Post')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Post</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('posts.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="subcategory_id" class="form-label">Subcategory</label>
                    <select class="form-select @error('subcategory_id') is-invalid @enderror" id="subcategory_id" name="subcategory_id">
                        <option value="">Select Subcategory</option>
                        @foreach($subcategories as $subcategory)
                            @if($subcategory->category_id == old('category_id', $post->category_id))
                                <option value="{{ $subcategory->id }}" {{ old('subcategory_id', $post->subcategory_id) == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('subcategory_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.getElementById('category_id');
        const subcategorySelect = document.getElementById('subcategory_id');
        const subcategories = @json($subcategories);
        
        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;
            
            // Clear subcategory select if no category is selected
            if (!categoryId) {
                subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                return;
            }
            
            // Filter subcategories based on selected category
            const filteredSubcategories = subcategories.filter(sub => sub.category_id == categoryId);
            
            // Populate subcategory select
            subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
            filteredSubcategories.forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.id;
                option.textContent = sub.name;
                subcategorySelect.appendChild(option);
            });
        });
    });
</script>
@endpush
@endsection