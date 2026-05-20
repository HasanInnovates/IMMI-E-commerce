@extends('layouts.admin')

@section('title', 'Create Role')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Create Role</h4>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.roles.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" id="name" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required autofocus
                               placeholder="e.g. Editor">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" id="slug" name="slug"
                               class="form-control @error('slug') is-invalid @enderror"
                               value="{{ old('slug') }}" required
                               placeholder="editor"
                               pattern="^[a-z0-9-]+$"
                               title="Lowercase letters, numbers, and hyphens only">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Lowercase letters, numbers, and hyphens only.</div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description"
                                  class="form-control @error('description') is-invalid @enderror"
                                  rows="2" placeholder="Optional description of this role">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Permissions</label>
                        <div class="border rounded p-3 bg-light" style="max-height:300px;overflow-y:auto;">
                            @foreach($permissions as $perm)
                            <div class="form-check">
                                <input type="checkbox" id="perm_{{ $perm->id }}" name="permissions[]"
                                       class="form-check-input" value="{{ $perm->id }}"
                                       {{ in_array($perm->id, old('permissions', [])) ? 'checked' : '' }}>
                                <label for="perm_{{ $perm->id }}" class="form-check-label">
                                    {{ $perm->name }}
                                    <small class="text-muted">({{ $perm->slug }})</small>
                                </label>
                            </div>
                            @endforeach
                        </div>
                        @error('permissions')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Create Role
                        </button>
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
