@extends('layouts.admin')

@section('title', 'Permission Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <h4 class="mb-0">Permission Management</h4>
    <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Permission
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Roles Using</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permissions as $perm)
                <tr>
                    <td class="align-middle">{{ $perm->id }}</td>
                    <td class="align-middle fw-medium">{{ $perm->name }}</td>
                    <td class="align-middle"><code>{{ $perm->slug }}</code></td>
                    <td class="align-middle text-muted">{{ Str::limit($perm->description, 50) }}</td>
                    <td class="align-middle">
                        <span class="badge bg-info">{{ $perm->roles_count }}</span>
                    </td>
                    <td class="align-middle text-end">
                        <a href="{{ route('admin.permissions.edit', $perm) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form method="POST" action="{{ route('admin.permissions.destroy', $perm) }}" class="d-inline"
                              onsubmit="return confirm('Delete permission &quot;{{ $perm->name }}&quot;? Roles using it will lose this permission.')">
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
                        <i class="bi bi-shield-check d-block fs-2 mb-2"></i>
                        No permissions found. <a href="{{ route('admin.permissions.create') }}">Create one</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($permissions->hasPages())
    <div class="card-footer bg-white">
        {{ $permissions->links() }}
    </div>
    @endif
</div>
@endsection
