@extends('layouts.admin')

@section('title', 'Message from ' . $contactMessage->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Message from {{ $contactMessage->name }}</h4>
        <small class="text-muted">Received on {{ $contactMessage->created_at->format('F d, Y \a\t h:i A') }}</small>
    </div>
    <div class="d-flex gap-2">
        <form method="POST" action="{{ route('admin.contacts.destroy', $contactMessage) }}"
              onsubmit="return confirm('Delete this message?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">
                <i class="bi bi-trash"></i> Delete
            </button>
        </form>
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">{{ $contactMessage->subject }}</h5>
            </div>
            <div class="card-body">
                <p class="mb-0" style="white-space: pre-wrap;">{{ $contactMessage->message }}</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Contact Details</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted d-block">Name</small>
                    <span class="fw-semibold">{{ $contactMessage->name }}</span>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">Email</small>
                    <a href="mailto:{{ $contactMessage->email }}" class="fw-semibold">{{ $contactMessage->email }}</a>
                </div>
                @if($contactMessage->phone)
                <div class="mb-3">
                    <small class="text-muted d-block">Phone</small>
                    <span class="fw-semibold">{{ $contactMessage->phone }}</span>
                </div>
                @endif
                <div>
                    <small class="text-muted d-block">Status</small>
                    @if($contactMessage->is_read)
                        <span class="badge bg-secondary">Read</span>
                    @else
                        <span class="badge bg-warning text-dark">Unread</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
