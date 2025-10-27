@extends('layouts.app')

@section('title', $product->name . ' - Inventory Management System')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>
                <i class="fas fa-box me-2"></i>{{ $product->name }}
            </h2>
            <div class="btn-group" role="group">
                <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Product Details</h5>
                        <div class="row">
                            <div class="col-sm-3"><strong>SKU:</strong></div>
                            <div class="col-sm-9"><code>{{ $product->sku }}</code></div>
                            
                            <div class="col-sm-3"><strong>Category:</strong></div>
                            <div class="col-sm-9">
                                <span class="badge bg-secondary">{{ $product->category->name }}</span>
                            </div>
                            
                            <div class="col-sm-3"><strong>Price:</strong></div>
                            <div class="col-sm-9">
                                <h4 class="text-primary mb-0">₱{{ number_format($product->price, 2) }}</h4>
                            </div>
                            
                            <div class="col-sm-3"><strong>Quantity:</strong></div>
                            <div class="col-sm-9">
                                <span class="badge bg-{{ $product->quantity > 10 ? 'success' : ($product->quantity > 0 ? 'warning' : 'danger') }} fs-6">
                                    {{ $product->quantity }} units
                                </span>
                            </div>
                            
                            <div class="col-sm-3"><strong>Status:</strong></div>
                            <div class="col-sm-9">
                                @if($product->quantity > 10)
                                    <span class="badge bg-success">In Stock</span>
                                @elseif($product->quantity > 0)
                                    <span class="badge bg-warning">Low Stock</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </div>
                            
                            @if($product->description)
                                <div class="col-12 mt-3">
                                    <strong>Description:</strong>
                                    <p class="mt-2">{{ $product->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card hover-lift">
                    <div class="card-body">
                        <h6 class="card-title">Quick Actions</h6>
                        <div class="d-grid gap-2">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">
                                <i class="fas fa-edit me-1"></i>Edit Product
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-list me-1"></i>View All Products
                            </a>
                            <a href="{{ route('categories.show',  $product->category) }}" class="btn btn-outline-info">
                                <i class="fas fa-tag me-1"></i>View Category
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card mt-3 hover-lift">
                    <div class="card-body">
                        <h6 class="card-title">Product Information</h6>
                        <small class="text-muted">
                            <strong>Created:</strong> {{ $product->created_at->format('M d, Y H:i') }}<br>
                            <strong>Last Updated:</strong> {{ $product->updated_at->format('M d, Y H:i') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection