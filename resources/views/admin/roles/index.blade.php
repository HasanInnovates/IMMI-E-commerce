@extends('layouts.admin')

@section('title', 'Role Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <h4 class="mb-0">Role Management</h4>
    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Role
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
                    <th>Permissions</th>
                    <th>Users</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr>
                    <td class="align-middle">{{ $role->id }}</td>
                    <td class="align-middle fw-medium">{{ $role->name }}</td>
                    <td class="align-middle"><code>{{ $role->slug }}</code></td>
                    <td class="align-middle text-muted">{{ Str::limit($role->description, 50) }}</td>
                    <td class="align-middle">
                        <span class="badge bg-info">{{ $role->permissions_count }}</span>
                    </td>
                    <td class="align-middle">
                        <span class="badge bg-secondary">{{ $role->users_count }}</span>
                    </td>
                    <td class="align-middle text-end">
                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        @if($role->slug !== 'super-admin')
                        <form method="POST" action="{{ route('admin.roles.destroy', $role) }}" class="d-inline"
                              onsubmit="return confirm('Delete role &quot;{{ $role->name }}&quot;? Users with this role will lose its permissions.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-person-badge d-block fs-2 mb-2"></i>
                        No roles found. <a href="{{ route('admin.roles.create') }}">Create one</a>.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($roles->hasPages())
    <div class="card-footer bg-white">
        {{ $roles->links() }}
    </div>
    @endif
</div>
@endsection
