@extends('layouts.admin')

@section('title', 'Product Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <h4 class="mb-0">Product Management</h4>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Product
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2 align-items-end">
            <div class="col-md-6 col-lg-4">
                <label class="form-label small text-muted">Search by name or slug</label>
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search products..."
                           value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    @if($search)
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-danger">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px">Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-end" style="width:180px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>
                            @if($product->image_url)
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                     class="rounded" width="50" height="50" style="object-fit:cover">
                            @else
                                <div class="bg-secondary bg-opacity-10 rounded d-flex align-items-center justify-content-center"
                                     style="width:50px;height:50px">
                                    <i class="bi bi-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-medium">{{ $product->name }}</td>
                        <td>
                            <span class="badge bg-label-{{ $product->category->name ?? 'secondary' }}"
                                  style="background:#e8f0fe;color:#1a73e8">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td class="fw-semibold">${{ number_format($product->price, 2) }}</td>
                        <td>
                            @php
                                $stockClass = $product->isOutOfStock() ? 'danger' : ($product->isLowStock() ? 'warning text-dark' : 'success');
                            @endphp
                            <span class="badge bg-{{ explode(' ', $stockClass)[0] }} {{ str_contains($stockClass, 'text-dark') ? 'text-dark' : '' }}">
                                {{ $product->stock }}
                                @if($product->isOutOfStock())
                                    <i class="bi bi-exclamation-triangle ms-1"></i>
                                @endif
                            </span>
                        </td>
                        <td>
                            @if($product->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete &quot;{{ $product->name }}&quot;? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            @if($search)
                                <i class="bi bi-search d-block fs-2 mb-2"></i>
                                No products match "{{ $search }}".
                            @else
                                <i class="bi bi-box-seam d-block fs-2 mb-2"></i>
                                No products yet.
                                <a href="{{ route('admin.products.create') }}">Add your first product</a>.
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($products->hasPages())
    <div class="card-footer bg-white d-flex justify-content-center">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
