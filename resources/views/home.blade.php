@extends('layouts.app')

@section('title', 'Home - Inventory Management System')

@section('content')
<div class="py-3">
    <div class="p-5 mb-4 rounded-3" style="background: linear-gradient(135deg, #0ea5e9, #22c55e); color: #fff;">
        <div class="container-xxl px-3 py-2">
            <h1 class="display-6 fw-bold mb-2 d-flex align-items-center">
                <i class="fas fa-warehouse me-2"></i>
                Inventory overview
            </h1>
            <p class="col-md-8 mb-0">Manage categories and products.</p>
            <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                <a href="{{ route('categories.index') }}" class="btn btn-light">
                    <i class="fas fa-tags me-1"></i>Manage Categories
                </a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-light">
                    <i class="fas fa-box me-1"></i>Manage Products
                </a>
            </div>
        </div>
    </div>

    
</div>
@endsection


