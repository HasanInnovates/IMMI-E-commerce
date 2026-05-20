@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Orders</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td class="fw-medium">#{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? $order->customer_name }}</td>
                        <td class="fw-semibold">{{ format_currency($order->total_price) }}</td>
                        <td>
                            <span class="badge bg-{{ \App\Helpers\OrderHelper::statusBadge($order->status) }}">
                                {{ \App\Helpers\OrderHelper::statusLabel($order->status) }}
                            </span>
                        </td>
                        <td>
                            @if($order->payment)
                                <span class="badge bg-{{ \App\Helpers\OrderHelper::paymentStatusBadge($order->payment->payment_status) }}">
                                    {{ ucfirst($order->payment->payment_status) }}
                                </span>
                            @else
                                <span class="text-muted">--</span>
                            @endif
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($orders->hasPages())
    <div class="card-footer bg-white d-flex justify-content-center">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
