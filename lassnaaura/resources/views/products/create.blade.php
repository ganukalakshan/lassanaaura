@extends('layouts.app')

@section('title', 'Add New Product - Business Management System')
@section('page-title', 'Add New Product')

@section('content')
<div class="page-container">
    <div class="page-header">
        <div class="page-header-content">
            <div class="page-header-left">
                <a href="{{ route('products.index') }}" class="btn btn-secondary btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Back to Products
                </a>
                <h2 class="page-header-title">
                    <i class="fas fa-box-open"></i>
                    Add New Product
                </h2>
            </div>
        </div>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-grid">
            <!-- Basic Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Basic Information</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="form-label required">Product Name</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="sku" class="form-label required">SKU</label>
                            <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" 
                                   value="{{ old('sku') }}" required>
                            @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="barcode" class="form-label">Barcode</label>
                            <input type="text" name="barcode" id="barcode" class="form-control @error('barcode') is-invalid @enderror" 
                                   value="{{ old('barcode') }}">
                            @error('barcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="4">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="category_id" class="form-label required">Category</label>
                            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                <option value="">Select Category</option>
                                @foreach($categories ?? [] as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-dollar-sign"></i> Pricing</h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="cost_price" class="form-label">Cost Price</label>
                            <input type="number" name="cost_price" id="cost_price" class="form-control" 
                                   value="{{ old('cost_price', '0') }}" step="0.01" min="0">
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="price" class="form-label required">Selling Price</label>
                            <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" 
                                   value="{{ old('price') }}" step="0.01" min="0" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tax_rate" class="form-label">Tax Rate (%)</label>
                            <input type="number" name="tax_rate" id="tax_rate" class="form-control" 
                                   value="{{ old('tax_rate', '0') }}" step="0.01" min="0" max="100">
                        </div>
                        
                        <div class="form-group col-md-6">
                            <label for="discount" class="form-label">Discount (%)</label>
                            <input type="number" name="discount" id="discount" class="form-control" 
                                   value="{{ old('discount', '0') }}" step="0.01" min="0" max="100">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-warehouse"></i> Inventory</h3>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="stock" class="form-label">Current Stock</label>
                            <input type="number" name="stock" id="stock" class="form-control" 
                                   value="{{ old('stock', '0') }}" min="0">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="low_stock_threshold" class="form-label">Low Stock Alert</label>
                            <input type="number" name="low_stock_threshold" id="low_stock_threshold" class="form-control" 
                                   value="{{ old('low_stock_threshold', '10') }}" min="0">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="unit" class="form-label">Unit</label>
                            <select name="unit" id="unit" class="form-control">
                                <option value="piece">Piece</option>
                                <option value="box">Box</option>
                                <option value="kg">Kilogram</option>
                                <option value="liter">Liter</option>
                                <option value="meter">Meter</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="warehouse_id" class="form-label">Warehouse</label>
                        <select name="warehouse_id" id="warehouse_id" class="form-control">
                            <option value="">Main Warehouse</option>
                            @foreach($warehouses ?? [] as $warehouse)
                            <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Images -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-images"></i> Product Images</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="image" class="form-label">Main Image</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*" onchange="previewImage(event)">
                        <div id="imagePreview" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="fas fa-save"></i> Save Product
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" style="max-width: 200px; border-radius: 0.375rem;">`;
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endpush
@endsection
