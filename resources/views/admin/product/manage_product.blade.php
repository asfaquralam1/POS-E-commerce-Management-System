@extends('admin.master')

@section('page_title', 'Products')
@section('product_select', 'active')

@section('content')
<div class="layout-wrapper">
    @include('admin.partials.sidebar')
    
    <div class="content-wrapper p-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Products Management</h4>
            </div>
            <div class="d-flex gap-2">
                <a class="btn btn-primary shadow-sm" href="{{ route('admin.printbarcode.product') }}">
                    <i class="fas fa-barcode me-1"></i> Print Barcodes
                </a>
                <a class="btn btn-success shadow-sm" href="{{ route('admin.manage.product') }}">
                    <i class="fas fa-plus me-1"></i> Add New Product
                </a>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden px-3 py-2">
            <div class="table-responsive">
                <table id="table" class="table table-hover align-middle mb-0">
                    <thead class="table-light border-bottom text-uppercase fs-7 text-secondary">
                        <tr>
                            <th class="text-center py-3" style="width: 50px;">#</th>
                            <th class="py-3">Product Name</th>
                            <th class="py-3">Barcode</th>
                            <th class="py-3">Category</th>
                            <th class="py-3">Short Description</th>
                            <th class="py-3 text-end">Price</th>
                            <th class="py-3 text-end">Discount Price</th>
                            <th class="py-3 text-center">Stock</th>
                            <th class="py-3 text-center" style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse ($products as $product)
                        <tr>
                            <td class="text-center text-muted fw-medium">{{ $loop->iteration }}</td>
                            
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded bg-light border p-1 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                        @if($product->image)
                                            <img src="/product/{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid rounded object-fit-cover w-100 h-100">
                                        @else
                                            <i class="fas fa-box text-muted"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold text-dark">{{ $product->name }}</h6>
                                    </div>
                                </div>
                            </td>
                            
                            <td>
                                <span class="font-monospace text-secondary small bg-light px-2 py-1 rounded border">
                                    {{ $product->barcode }}
                                </span>
                            </td>
                            
                            <td>
                                <span class="badge bg-info-subtle text-info px-2.5 py-1.5 rounded fs-7 border border-info-subtle fw-medium">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            
                            <td>
                                <span class="text-muted small text-truncate d-inline-block" style="max-width: 180px;" title="{{ $product->details }}">
                                    {{ $product->details }}
                                </span>
                            </td>
                            
                            <td class="text-end fw-semibold text-dark">
                                Tk{{ number_format($product->price, 2) }}
                            </td>
                            
                            <td class="text-end">
                                @if($product->discount_price)
                                    <span class="text-success fw-medium">Tk{{ number_format($product->discount_price, 2) }}</span>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>
                            
                            <td class="text-center">
                                @if($product->quantity <= 0)
                                    <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded">Out of stock</span>
                                @elseif($product->quantity <= 5)
                                    <span class="badge bg-warning-subtle text-warning px-2 py-1 rounded">{{ $product->quantity }} Low</span>
                                @else
                                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded">{{ $product->quantity }} Pcs</span>
                                @endif
                            </td>
                            
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a class="btn btn-sm btn-outline-primary rounded-2 px-2" 
                                       href="{{ route('admin.edit.product', $product->id) }}" 
                                       title="Edit Product">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.destroy.product', $product->id) }}" method="post" class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger rounded-2 px-2" 
                                                onclick="return confirm('Are you sure you want to delete this product? This action cannot be undone.');" 
                                                title="Delete Product">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fs-2 mb-3 d-block text-secondary"></i>
                                No products found in your database.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection