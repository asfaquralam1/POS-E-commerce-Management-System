@extends('admin.master')
@section('page_title', 'Add Category')
@section('category_select', 'active')

@section('content')
<div class="layout-wrapper">
    @include('admin.partials.sidebar')
    
    <div class="content-wrapper">
        <div class="card-title d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">Add New Category</h5>
            <a class="btn btn-warning back-btn" href="{{ route('admin.category') }}">
                <i class="fas fa-backward me-1"></i> Go Back
            </a>
        </div>

        <div class="add-form card p-4 shadow-sm">
            <form action="{{ route('admin.add.category') }}" method="post" enctype="multipart/form-data">
                @csrf
                <h5 class="mb-4 text-center text-muted">Category Information</h5>
                
                <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="category_name" class="form-label fw-bold">Category Name <span
                                    class="text-danger">*</span></label>
                            <input id="category_name" name="name" type="text"
                                class="form-control @error('name') is-invalid @enderror" value="{{ $category->name }}"
                                required placeholder="e.g., Electronics">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="editor1" class="form-label fw-bold">Description</label>
                            <textarea id="editor1" name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                rows="5">{{ $category->description }}</textarea>
                            @error('description')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="parent_category" class="form-label fw-bold">Parent Category</label>
                            <select id="parent_category" name="parent_id" class="form-select">
                                <option value="">Select Parent Category</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" {{ old('parent_id', $category->parent_id) == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('parent_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label fw-bold">Status</label>
                            <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }}>
                                    Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success px-4 py-2">
                        <i class="fas fa-save me-1"></i> Save Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.19.0/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor1', {
        height: 300,
        baseFloatZIndex: 10005,
        removeButtons: 'PasteFromWord'
    });
</script>
@endsection