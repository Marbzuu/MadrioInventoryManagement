@extends('layouts.app')

@section('title', 'Products - Inventory Management System')

@section('content')
@php /** @var \Illuminate\Pagination\LengthAwarePaginator $products */ @endphp
<div class="mb-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <div>
            <h2 class="mb-1">
                <i class="fas fa-box me-2" style="background: var(--warning-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;"></i>
                Products
                <span class="badge bg-light text-dark ms-2">Total: {{ $products->total() }}</span>
            </h2>
            <p class="text-muted mb-0">Manage your inventory products with detailed tracking and monitoring</p>
        </div>
        <form method="GET" action="{{ route('products.index') }}" class="d-flex flex-wrap align-items-stretch justify-content-md-end ms-md-auto w-100 gap-2">
            <div class="input-group flex-grow-1 flex-md-grow-0" style="min-width:260px; max-width: 320px;">
                <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Search name, SKU, or description...">
            </div>
            <select class="form-select" name="category_id" style="min-width:200px; max-width: 240px;">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ (string)($selectedCategoryId ?? '') === (string)$category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-outline-primary">Search</button>
            @if(!empty($q) || !empty($selectedCategoryId))
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Clear</a>
            @endif
            <button type="button" class="btn btn-primary ms-auto ms-md-0" data-bs-toggle="modal" data-bs-target="#createProductModal">
                <i class="fas fa-plus me-1"></i>Add New Product
            </button>
        </form>
    </div>
</div>

@if($products->count() > 0)
    <div class="card shadow-sm rounded-12 fade-in">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 table-modern">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 1;">
                <tr>
                    <th class="border-0">Name</th>
                    <th class="border-0">SKU</th>
                    <th class="border-0">Category</th>
                    <th class="border-0 text-end">Price</th>
                    <th class="border-0 text-center">Quantity</th>
                    <th class="border-0 text-center">Status</th>
                    <th class="border-0 text-center">Actions</th>
                </tr>
                    </thead>
                    <tbody class="align-middle">
                @foreach($products as $product)
                    <tr>
                        <td class="align-middle">
                            <div>
                                <strong>{{ $product->name }}</strong>
                                @if($product->description)
                                    <br><small class="text-muted">{{ \Illuminate\Support\Str::limit($product->description, 50) }}</small>
                                @endif
                            </div>
                        </td>
                        <td class="align-middle"><code class="bg-light px-2 py-1 rounded">{{ $product->sku }}</code></td>
                        <td class="align-middle"><span class="badge bg-secondary">{{ $product->category->name }}</span></td>
                        <td class="align-middle text-end"><strong class="text-primary">₱{{ number_format($product->price, 2) }}</strong></td>
                        <td class="align-middle text-center">
                            <span class="badge bg-{{ $product->quantity > 10 ? 'success' : ($product->quantity > 0 ? 'warning' : 'danger') }} fs-6">
                                {{ $product->quantity }}
                            </span>
                        </td>
                        <td class="align-middle text-center">
                            @if($product->quantity > 10)
                                <span class="badge badge-soft-success">In Stock</span>
                            @elseif($product->quantity > 0)
                                <span class="badge badge-soft-warning">Low Stock</span>
                            @else
                                <span class="badge badge-soft-danger">Out of Stock</span>
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-icon-sm" data-bs-toggle="tooltip" title="View details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-secondary btn-icon-sm" data-bs-toggle="tooltip" title="Edit product">
                                    <i class="fas fa-pen"></i>
                                </a>
                                <form id="delete-product-{{ $product->id }}" action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-icon-sm" data-bs-toggle="tooltip" title="Delete product"
                                            data-delete-form="delete-product-{{ $product->id }}" data-item-name="{{ $product->name }}">
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
        <small class="text-muted">Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}</small>
        <div>{{ $products->links() }}</div>
    </div>
@else
    <div class="text-center py-5">
        <i class="fas fa-box fa-3x text-muted mb-3"></i>
        <h4 class="text-muted">No products found</h4>
        <p class="text-muted">Get started by creating your first product.</p>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
            <i class="fas fa-plus me-1"></i>Create First Product
        </button>
    </div>
@endif
<!-- Create Product Modal -->
<div class="modal fade" id="createProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('products.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name *</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sku" class="form-label">SKU *</label>
                                <input type="text" class="form-control" id="sku" name="sku" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category *</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="price" class="form-label">Price *</label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" step="0.01" min="0" class="form-control" id="price" name="price" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity *</label>
                                <input type="number" min="0" class="form-control" id="quantity" name="quantity" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
