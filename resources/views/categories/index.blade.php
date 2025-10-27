@extends('layouts.app')

@section('title', 'Categories - Inventory Management System')

@section('content')
@php /** @var \Illuminate\Pagination\LengthAwarePaginator $categories */ @endphp
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h2 class="mb-1 section-title d-flex align-items-center">
                <i class="fas fa-tags me-2 text-gradient-success"></i>
                Categories
                <span class="badge bg-light text-dark ms-2">Total: {{ $categories->total() }}</span>
            </h2>
            <p class="text-muted mb-0">Manage your product categories and organize your inventory</p>
        </div>
        <form method="GET" action="{{ route('categories.index') }}" class="d-flex flex-wrap align-items-stretch justify-content-md-end ms-md-auto w-100 gap-2">
            <div class="input-group flex-grow-1 flex-md-grow-0" style="min-width:260px; max-width: 360px;">
                <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Search categories by name or description...">
                @if(!empty($q))
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">Clear</a>
                @endif
            </div>
            <button type="submit" class="btn btn-outline-primary">Search</button>
            <button type="button" class="btn btn-primary btn-shadow ms-auto ms-md-0" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                <i class="fas fa-plus me-1"></i>Add New Category
            </button>
        </form>
    </div>
    </div>

@if($categories->count() > 0)
    <div class="card shadow-sm rounded-12 fade-in">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="categoriesTable" class="table table-hover mb-0 table-modern">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 1;">
                        <tr>
                            <th class="border-0">Name</th>
                            <th class="border-0">Description</th>
                            <th class="border-0 text-center">Products</th>
                            <th class="border-0 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach($categories as $category)
                            <tr>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                </td>
                                <td style="max-width: 520px;" class="text-muted">
                                    <span class="d-inline-block text-truncate" style="max-width: 500px;">
                                        {{ $category->description ?: 'No description provided.' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-soft-info">
                                        <i class="fas fa-box me-1"></i>{{ $category->products_count }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('categories.show', $category) }}" class="btn btn-outline-primary btn-icon-sm" data-bs-toggle="tooltip" title="View details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-outline-secondary btn-icon-sm" data-bs-toggle="tooltip" title="Edit category">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <form id="delete-category-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-outline-danger btn-icon-sm" data-bs-toggle="tooltip" title="Delete category"
                                                    data-delete-form="delete-category-{{ $category->id }}" data-item-name="{{ $category->name }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-4">
        <small class="text-muted">Showing {{ $categories->firstItem() }}–{{ $categories->lastItem() }} of {{ $categories->total() }}</small>
        <div>
            {{ $categories->links() }}
        </div>
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">No categories found</h4>
        <p class="text-muted">Get started by creating your first category.</p>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
            <i class="fas fa-plus me-1"></i>Create First Category
        </button>
    </div>
@endif

<!-- Create Category Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('categories.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@push('scripts')
<!-- No extra scripts required: search is performed server-side. -->
@endpush
@endsection
