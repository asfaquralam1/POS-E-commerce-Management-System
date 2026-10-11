@extends('admin.master')
@section('page_title', 'Categories')
@section('category_select', 'active')

@section('content')
<div class="layout-wrapper">
    @include('admin.partials.sidebar')
    
    <div class="content-wrapper">
        <div class="card-title d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">Categories</h5>
            <a class="btn btn-success add-btn" href="{{ route('admin.manage.category') }}">
                <i class="fas fa-plus me-1"></i> Add Category
            </a>
        </div>

        <div class="table_area card p-3 shadow-sm border-0">
            <div class="table-responsive">
                <table id="table" class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col"> Name </th>
                            <th scope="col"> Description </th>
                            <th scope="col"> Parent </th>
                            <th scope="col" class="text-center"> Status </th>
                            <th scope="col" class="text-end pe-3"> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr>
                            <td class="fw-semibold">{{ $category->name }}</td>
                            <td class="text-ceter">{{ $category->description }}</td>
                            <td class="text-ceter">{{ $category->parent->name ?? 'No Parent' }}</td>
                            <td class="text-center">
                                @if ($category->status == 1)
                                    <span class="badge rounded-pill bg-success px-2.5">Active</span>
                                @else
                                    <span class="badge rounded-pill bg-danger px-2.5">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end pe-3">
                                <div class="d-flex justify-content-end gap-1">
                                    <form action="{{ route('admin.status.category', ['status' => $category->status == 1 ? 0 : 1, 'id' => $category->id]) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $category->status == 1 ? 'btn-outline-success' : 'btn-outline-secondary' }}" title="Toggle Status">
                                            <i class="fas {{ $category->status == 1 ? 'fa-toggle-on' : 'fa-toggle-off' }} fa-lg"></i>
                                        </button>
                                    </form>

                                    <a class="btn btn-sm btn-warning" href="{{ route('admin.edit.category', $category->id) }}" title="Edit Category">
                                        <i class="fas fa-edit text-white"></i>
                                    </a>

                                    <form action="{{ route('admin.destroy.category', $category->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete Category">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                No categories found. Click "Add Category" to get started.
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