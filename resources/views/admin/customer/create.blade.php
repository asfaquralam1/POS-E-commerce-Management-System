@extends('admin.master')

@section('page_title', 'Create Customer')
@section('customer_select', 'active')

@section('content')
    <div class="layout-wrapper">
        @include('admin.partials.sidebar')
        
        <div class="content-wrapper p-4">
            <!-- Header Section -->
            <div class="container-fluid d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark mb-0">Create New Customer</h4>
                <a class="btn btn-warning shadow-sm" href="{{ route('admin.customer') }}">
                    <i class="fas fa-arrow-left me-2"></i> Go Back
                </a>
            </div>

            <!-- Form Section -->
            <div class="container-fluid">
                <form action="{{ route('admin.customer.create') }}" method="post" enctype="multipart/form-data">
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

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="brand_id" class="form-label fw-medium"> Brand <span class="text-danger">*</span></label>
                                            <select id="brand_id" name="brand_id" class="form-select form-select-lg @error('brand') is-invalid @enderror" required>
                                                <option value="">Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('brand')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="unit_id" class="form-label fw-medium"> Unit <span class="text-danger">*</span></label>
                                            <select id="unit_id" name="unit_id" class="form-select form-select-lg @error('unit') is-invalid @enderror" required>
                                                <option value="">Select Unit</option>
                                                @foreach ($units as $unit)
                                                    <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('unit')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Pricing & Stock Row -->
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="price" class="form-label fw-medium"> Purchase price <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text">Tk</span>
                                                <input id="purchase_price" name="purchase_price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" placeholder="0.00" required>
                                            </div>
                                            @error('purchase_price')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="selling_price" class="form-label fw-medium"> Selling Price</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Tk</span>
                                                <input id="selling_price" name="selling_price" type="number" step="0.01" class="form-control @error('selling_price') is-invalid @enderror" placeholder="0.00">
                                            </div>
                                            @error('selling_price')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="alert_quantity" class="form-label fw-medium"> Alert Quantity <span class="text-danger">*</span></label>
                                            <input id="alert_quantity" name="alert_quantity" type="number" class="form-control @error('alert_quantity') is-invalid @enderror" placeholder="0" required>
                                            @error('alert_quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group mb-3">
                                            <label for="sku" class="form-label fw-medium"> Sku <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input id="sku" name="sku" type="text" class="form-control @error('Sku') is-invalid @enderror" placeholder="sku number" required>
                                            </div>
                                            @error('sku')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Barcode Field with Connected Button -->
                                    <div class="col-6">
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

                                     <!-- Product Details -->
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <label for="details" class="form-label fw-medium"> Product Short Details </label>
                                            <input id="details" name="details" type="text" class="form-control @error('details') is-invalid @enderror" placeholder="Brief introduction of product">
                                            @error('details')
                                                <div class="invalid-feedback">{{ $message }}</div>
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
@endsection