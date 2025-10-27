@extends('layouts.app')

@section('title', $category->name . ' - Inventory Management System')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-tag me-2"></i>{{ $category->name }}
            </h2>
        </div>

        <div class="row">
            <!-- Left Column -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Category Details</h5>
                        <div class="row">
                            <div class="col-sm-3"><strong>Description:</strong></div>
                            <div class="col-sm-9">
                                {{ $category->description ?: 'No description provided.' }}
                            </div>

                            <div class="col-sm-3"><strong>Total Products:</strong></div>
                            <div class="col-sm-9">
                                <span class="badge bg-secondary">
                                    {{ $category->products->count() }} items
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($category->products->count() > 0)
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>Products in this Category</h5>
                    </div>

                    <div class="row">
                        @foreach($category->products as $product)
                            <div class="col-md-6 col-lg-6 mb-3">
                                <div class="card hover-lift">
                                    <div class="card-body">
                                        <h6 class="card-title">{{ $product->name }}</h6>
                                        <p class="card-text">
                                            <small class="text-muted">SKU: {{ $product->sku }}</small><br>
                                            <strong class="text-primary">₱{{ number_format($product->price, 2) }}</strong> | 
                                            <span class="badge bg-{{ $product->quantity > 10 ? 'success' : ($product->quantity > 0 ? 'warning' : 'danger') }}">
                                                {{ $product->quantity }} in stock
                                            </span>
                                        </p>
                                        <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-box fa-2x text-muted mb-3"></i>
                        <h5 class="text-muted">No products in this category</h5>
                        <p class="text-muted">Add some products to this category to get started.</p>
                        <a href="{{ route('products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>Add First Product
                        </a>
                    </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="col-md-4">
                <div class="card hover-lift">
                    <div class="card-body">
                        <h6 class="card-title">Quick Actions</h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i>Edit Category
                            </a>
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-list me-1"></i>View All Categories
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card mt-3 hover-lift">
                    <div class="card-body">
                        <h6 class="card-title">Category Information</h6>
                        <small class="text-muted">
                            <strong>Created:</strong> {{ $category->created_at->format('M d, Y H:i') }}<br>
                            <strong>Last Updated:</strong> {{ $category->updated_at->format('M d, Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
