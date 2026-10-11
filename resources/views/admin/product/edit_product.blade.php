@extends('admin.master')

@section('page_title', 'Edit Product')
@section('category_select', 'active')

@section('content')
    <div class="layout-wrapper">
        @include('admin.partials.sidebar')
        
        <div class="content-wrapper p-4">
            <div class="container-fluid d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark mb-0">Edit Product</h4>
                <a class="btn btn-warning shadow-sm" href="{{ route('admin.product') }}">
                    <i class="fas fa-arrow-left me-2"></i> Go Back
                </a>
            </div>

            <div class="container-fluid">
                <form action="{{ route('admin.update.product', $product->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm rounded-3 p-4 h-100">
                                <h5 class="mb-4 text-primary border-bottom pb-2 fw-semibold">
                                    <i class="fas fa-info-circle me-2"></i>Product Information
                                </h5>
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label fw-medium">Product Name <span class="text-danger">*</span></label>
                                            <input id="name" name="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="category_id" class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                                            <select id="category_id" name="category_id" class="form-select form-select-lg @error('category_id') is-invalid @enderror" required>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="brand_id" class="form-label fw-medium"> Brand <span class="text-danger">*</span></label>
                                            <select id="brand_id" name="brand_id" class="form-select form-select-lg @error('brand_id') is-invalid @enderror" required>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('brand_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="unit_id" class="form-label fw-medium"> Unit <span class="text-danger">*</span></label>
                                            <select id="unit_id" name="unit_id" class="form-select form-select-lg @error('unit_id') is-invalid @enderror" required>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}" {{ old('unit_id', $product->unit_id) == $unit->id ? 'selected' : '' }}>
                                                        {{ $unit->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('unit_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="purchase_price" class="form-label fw-medium"> Purchase Price <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">Tk</span>
                                                <input id="purchase_price" name="purchase_price" type="number" step="0.01" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price', $product->purchase_price) }}" required>
                                            </div>
                                            @error('purchase_price')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="selling_price" class="form-label fw-medium">Discount Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Tk</span>
                                                <input id="selling_price" name="selling_price" type="number" step="0.01" class="form-control @error('selling_price') is-invalid @enderror" value="{{ old('selling_price', $product->selling_price) }}">
                                            </div>
                                            @error('selling_price')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="alert_quantity" class="form-label fw-medium"> Alert Quantity <span class="text-danger">*</span></label>
                                            <input id="alert_quantity" name="alert_quantity" type="number" class="form-control @error('alert_quantity') is-invalid @enderror" value="{{ old('alert_quantity', $product->alert_quantity) }}" required>
                                            @error('alert_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label for="barcode" class="form-label fw-medium">Barcode <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input id="barcode" name="barcode" type="text" class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode', $product->barcode) }}" readonly>
                                            </div>
                                            @error('barcode')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                     <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label for="sku" class="form-label fw-medium"> Sku <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input id="sku" name="sku" type="text" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}" required>
                                            </div>
                                            @error('sku')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="details" class="form-label fw-medium">Product Details <span class="text-danger">*</span></label>
                                            <input id="details" name="details" type="text" class="form-control @error('details') is-invalid @enderror" value="{{ old('details', $product->details) }}">
                                            @error('details')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm rounded-3 p-4 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="mb-4 text-primary border-bottom pb-2 fw-semibold">
                                        <i class="fas fa-images me-2"></i>Product Media
                                    </h5>

                                    <div class="text-center mb-4">
                                        <h6 class="text-start fw-medium mb-2">Main Product Image</h6>
                                        <div class="position-relative d-inline-block bg-light rounded border p-2 mb-2" id="imageContainer" style="cursor: pointer; width: 100%; max-width: 220px; aspect-ratio: 1;">
                                            <img id="imagePreview" src="/product/{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid rounded w-100 h-100 object-fit-cover">
                                            <label for="mainImage" id="editIcon" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 m-2 rounded-circle shadow">
                                                <i class="fas fa-pencil-alt"></i>
                                            </label>
                                        </div>
                                        <input id="mainImage" name="image" type="file" accept="image/*" style="display: none;">
                                        @error('image')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group mt-3">
                                        <h6 class="fw-medium mb-2">Additional Gallery Images</h6>
                                        <div class="input-images bg-light p-2 rounded border"></div>
                                        <div class="form-text text-muted small mt-1">
                                            <i class="las la-info-circle"></i> You can upload a maximum of 5 images in total.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-4 pt-4 border-top">
                                    <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm">
                                        <i class="fas fa-save me-2"></i> Update Product
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="{{ asset('css/image-uploader.min.css') }}">
    <script src="{{ asset('js/image-uploader.min.js') }}"></script>

    <script>
        (function($) {
            "use strict";

            let preloaded = [];
            @if (!empty($preloadedImages))
                preloaded = @json($preloadedImages); 
            @endif

            $('.input-images').imageUploader({
                preloaded: preloaded,
                imagesInputName: 'thumbs',
                preloadedInputName: 'old', 
                maxFiles: 5
            });

            const imageUpload = document.getElementById('mainImage');
            const previewImage = document.getElementById('imagePreview');
            const editIcon = document.getElementById('editIcon');

            if (previewImage && imageUpload) previewImage.addEventListener('click', () => imageUpload.click());
            if (editIcon && imageUpload) editIcon.addEventListener('click', () => imageUpload.click());

            if (imageUpload && previewImage) {
                imageUpload.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = e => previewImage.src = e.target.result;
                        reader.readAsDataURL(file);
                    }
                });
            }

            window.generateBarcode = function() {
                let barcode = Date.now() + Math.floor(Math.random() * 90 + 10);
                document.getElementById('barcode').value = barcode;
            };
        })(jQuery);
    </script>
@endsection