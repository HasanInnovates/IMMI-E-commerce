@extends('layouts.admin')

@section('title', 'Add Delivery Charge')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Add Delivery Area</h4>
    <a href="{{ route('admin.delivery-charges.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.delivery-charges.store') }}">
            @csrf

            <div class="mb-3">
                <label for="area_name" class="form-label">Area Name <span class="text-danger">*</span></label>
                <input type="text" id="area_name" name="area_name"
                       class="form-control @error('area_name') is-invalid @enderror"
                       value="{{ old('area_name') }}" required>
                @error('area_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="charge" class="form-label">Delivery Charge <span class="text-danger">*</span></label>
                <div class="input-group">
                    <span class="input-group-text">৳</span>
                    <input type="number" step="0.01" min="0" id="charge" name="charge"
                           class="form-control @error('charge') is-invalid @enderror"
                           value="{{ old('charge', '0') }}" required>
                    @error('charge') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" id="status" name="status"
                           class="form-check-input" value="1" checked>
                    <label for="status" class="form-check-label">Active</label>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-lg"></i> Save
            </button>
        </form>
    </div>
</div>
@endsection
