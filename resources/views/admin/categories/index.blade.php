@extends('layouts.admin')

@section('title', 'Category Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <h4 class="mb-0">Category Management</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Category
    </a>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-2 align-items-end">
            <div class="col-md-6 col-lg-4">
                <label class="form-label small text-muted">Search by name</label>
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search categories..."
                           value="{{ $search }}">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    @if($search)
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-danger">
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
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Products</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td class="align-middle">{{ $cat->id }}</td>
                    <td class="align-middle fw-medium">{{ $cat->name }}</td>
                    <td class="align-middle"><code>{{ $cat->slug }}</code></td>
                    <td class="align-middle">
                        <form method="POST" action="{{ route('admin.categories.toggle-status', $cat) }}" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm border-0 p-0"
                                    onclick="return confirm('Toggle status for &quot;{{ $cat->name }}&quot;?')">
                                @if($cat->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </button>
                        </form>
                    </td>
                    <td class="align-middle">{{ $cat->products_count }}</td>
                    <td class="align-middle text-end">
                        <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" class="d-inline"
                              onsubmit="return confirm('Delete category &quot;{{ $cat->name }}&quot;? This action cannot be undone.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        @if($search)
                            No categories match "{{ $search }}".
                        @else
                            <i class="bi bi-folder2-open d-block fs-2 mb-2"></i>
                            No categories found. <a href="{{ route('admin.categories.create') }}">Create one</a>.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
    <div class="card-footer bg-white">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection
