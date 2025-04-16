@extends('admin.layouts.master')

@section('title', 'Create Post')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Create New Post</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('posts.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5">{{ old('content') }}</textarea>
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
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="subcategory_id" class="form-label">Subcategory (Optional)</label>
                    <select class="form-select @error('subcategory_id') is-invalid @enderror" id="subcategory_id" name="subcategory_id" {{ old('category_id') ? '' : 'disabled' }}>
                        <option value="">Select Subcategory</option>
                        @if(old('category_id'))
                            @foreach($subcategories as $subcategory)
                                @if($subcategory->category_id == old('category_id'))
                                    <option value="{{ $subcategory->id }}" {{ old('subcategory_id') == $subcategory->id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @error('subcategory_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary me-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Save</button>
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
            
            // Clear and disable subcategory select if no category is selected
            if (!categoryId) {
                subcategorySelect.innerHTML = '<option value="">Select Subcategory</option>';
                subcategorySelect.disabled = true;
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
            
            subcategorySelect.disabled = false;
        });
        
        // Initialize subcategory select based on preselected category (for validation errors)
        if (categorySelect.value) {
            categorySelect.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
@endsection