@extends('admin.master')

@section('page_title', 'Create Product')
@section('product_select', 'active')

@section('content')
    <div class="layout-wrapper">
        @include('admin.partials.sidebar')
        
        <div class="content-wrapper p-4">
            <!-- Header Section -->
            <div class="container-fluid d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark mb-0">Create New Product</h4>
                <a class="btn btn-warning shadow-sm" href="{{ route('admin.product') }}">
                    <i class="fas fa-arrow-left me-2"></i> Go Back
                </a>
            </div>

            <!-- Form Section -->
            <div class="container-fluid">
                <form action="{{ route('admin.add.product') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row g-4">
                        <!-- Left Side: Product Details Card -->
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm rounded-3 p-4 h-100">
                                <h5 class="mb-4 text-primary border-bottom pb-2 fw-semibold">
                                    <i class="fas fa-info-circle me-2"></i>Product Information
                                </h5>
                                
                                <div class="row g-3">
                                    <!-- Product Name -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="name" class="form-label fw-medium">Product Name <span class="text-danger">*</span></label>
                                            <input id="name" name="name" type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter product name" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Category -->
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="category_id" class="form-label fw-medium">Category <span class="text-danger">*</span></label>
                                            <select id="category_id" name="category_id" class="form-select form-select-lg @error('category') is-invalid @enderror" required>
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Product Details / Short Description -->
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="details" class="form-label fw-medium">Product Short Details <span class="text-danger">*</span></label>
                                            <input id="details" name="details" type="text" class="form-control @error('details') is-invalid @enderror" value="{{ old('details') }}" placeholder="Brief introduction of product" required>
                                            @error('details')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Pricing & Stock Row -->
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="price" class="form-label fw-medium">Product Price <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">Tk</span>
                                                <input id="price" name="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" placeholder="0.00" required>
                                            </div>
                                            @error('price')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="discount_price" class="form-label fw-medium">Discount Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Tk</span>
                                                <input id="discount_price" name="discount_price" type="number" step="0.01" class="form-control @error('discount_price') is-invalid @enderror" value="{{ old('discount_price') }}" placeholder="0.00">
                                            </div>
                                            @error('discount_price')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="quantity" class="form-label fw-medium">Stock Quantity <span class="text-danger">*</span></label>
                                            <input id="quantity" name="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', 0) }}" placeholder="0" required>
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Barcode Field with Connected Button -->
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="barcode" class="form-label fw-medium">Barcode <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input id="barcode" name="barcode" type="text" class="form-control @error('barcode') is-invalid @enderror" value="{{ old('barcode') }}" placeholder="Scan or generate barcode" required>
                                                <button type="button" onclick="generateBarcode()" class="btn btn-dark">
                                                    <i class="fas fa-barcode me-1"></i> Generate
                                                </button>
                                            </div>
                                            @error('barcode')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Media / Image Upload Card -->
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm rounded-3 p-4 h-100">
                                <h5 class="mb-4 text-primary border-bottom pb-2 fw-semibold">
                                    <i class="fas fa-images me-2"></i>Product Media
                                </h5>

                                <!-- Main Feature Image -->
                                <div class="text-center mb-4">
                                    <h6 class="text-start fw-medium mb-2">Main Product Image <span class="text-danger">*</span></h6>
                                    <div class="position-relative d-inline-block bg-light rounded border p-2" id="imageContainer" style="cursor: pointer; width: 100%; max-width: 220px; aspect-ratio: 1;">
                                        <img id="imagePreview" src="{{ asset('image/upload.png') }}" alt="Default Image" class="img-fluid rounded w-100 h-100 object-fit-cover">
                                        <label for="mainImage" id="editIcon" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 m-2 rounded-circle shadow">
                                            <i class="fas fa-pencil-alt"></i>
                                        </label>
                                    </div>
                                    <input id="mainImage" name="image" type="file" accept="image/*" style="display: none;">
                                    @error('image')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Gallery / Additional Images -->
                                <div class="form-group mt-3">
                                    <h6 class="fw-medium mb-2">Additional Gallery Images</h6>
                                    <div id="input-images" class="bg-light p-2 rounded border"></div>
                                    <div class="form-text text-muted small mt-1">
                                        <i class="las la-info-circle"></i> You can upload a maximum of 4 gallery images.
                                    </div>
                                </div>
                                
                                <!-- Submit Button pinned at bottom of right card -->
                                <div class="mt-5 pt-4 border-top">
                                    <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm">
                                        <i class="fas fa-save me-2"></i> Save Product
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Error Modal (Bootstrap 5 Compatible) -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content position-relative border-0 shadow">
                <button type="button" class="btn-close position-absolute end-0 m-3 shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body text-center p-5">
                    <i class="fas fa-times-circle text-danger mb-3" style="font-size: 3.5rem;"></i>
                    <h4 class="text-danger mb-2">@lang('Cannot process your entry!')</h4>
                    <p class="text-muted mb-4">@lang("You can't add more than 5 images altogether.")</p>
                    <button type="button" class="btn btn-danger px-4" data-bs-dismiss="modal">@lang('Continue')</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stylesheets & Scripts -->
    <link rel="stylesheet" href="{{ asset('css/image-uploader.min.css') }}">
    <script src="{{ asset('js/image-uploader.min.js') }}"></script>

    <script>
        (function($) {
            "use strict";
            
            let preloaded = [];
            @if (isset($images))
                preloaded = @json($images);
            @endif

            $('#input-images').imageUploader({
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