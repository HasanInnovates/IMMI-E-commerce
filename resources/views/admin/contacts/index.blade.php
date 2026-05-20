@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Contact Messages</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                    <tr class="{{ !$msg->is_read ? 'fw-semibold' : '' }}">
                        <td>{{ $msg->id }}</td>
                        <td>{{ $msg->name }}</td>
                        <td>{{ $msg->email }}</td>
                        <td>{{ $msg->subject }}</td>
                        <td>
                            @if($msg->is_read)
                                <span class="badge bg-secondary">Read</span>
                            @else
                                <span class="badge bg-warning text-dark">Unread</span>
                            @endif
                        </td>
                        <td>{{ $msg->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.contacts.show', $msg) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                            <form method="POST" action="{{ route('admin.contacts.destroy', $msg) }}"
                                  class="d-inline" onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No messages yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($messages->hasPages())
    <div class="card-footer bg-white d-flex justify-content-center">
        {{ $messages->links() }}
    </div>
    @endif
</div>
@endsection
