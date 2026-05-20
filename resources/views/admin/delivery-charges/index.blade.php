@extends('layouts.admin')

@section('title', 'Delivery Charges')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Delivery Charges</h4>
    <a href="{{ route('admin.delivery-charges.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Add Area
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Area Name</th>
                        <th>Charge</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($charges as $c)
                    <tr>
                        <td>{{ $c->id }}</td>
                        <td class="fw-semibold">{{ $c->area_name }}</td>
                        <td>{{ format_currency($c->charge) }}</td>
                        <td>
                            @if($c->status)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.delivery-charges.edit', $c) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('admin.delivery-charges.destroy', $c) }}"
                                  class="d-inline" onsubmit="return confirm('Delete this delivery area?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">No delivery charges configured.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($charges->hasPages())
    <div class="card-footer bg-white d-flex justify-content-center">
        {{ $charges->links() }}
    </div>
    @endif
</div>
@endsection
