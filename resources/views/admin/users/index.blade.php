@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <h4 class="mb-0">User Management</h4>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add User
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Roles</th>
                    <th>Orders</th>
                    <th>Joined</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $userItem)
                <tr>
                    <td class="align-middle">{{ $userItem->id }}</td>
                    <td class="align-middle fw-medium">
                        {{ $userItem->name }}
                        @if($userItem->id === auth()->id())
                            <span class="badge bg-primary ms-1">You</span>
                        @endif
                    </td>
                    <td class="align-middle">{{ $userItem->email }}</td>
                    <td class="align-middle">
                        <span class="badge bg-{{ $userItem->role === 'admin' ? 'danger' : 'secondary' }}">
                            {{ $userItem->role }}
                        </span>
                    </td>
                    <td class="align-middle">
                        @foreach($userItem->roles as $role)
                            <span class="badge bg-info me-1">{{ $role->name }}</span>
                        @endforeach
                    </td>
                    <td class="align-middle">{{ $userItem->orders_count }}</td>
                    <td class="align-middle">{{ $userItem->created_at->format('M j, Y') }}</td>
                    <td class="align-middle text-end">
                        <a href="{{ route('admin.users.edit', $userItem) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        @if($userItem->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $userItem) }}" class="d-inline"
                              onsubmit="return confirm('Delete user &quot;{{ $userItem->name }}&quot;? This action cannot be undone.')">
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
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-people d-block fs-2 mb-2"></i>
                        No users found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="card-footer bg-white">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
