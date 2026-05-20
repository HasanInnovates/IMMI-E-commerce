<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Order Notification</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #dc3545; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #f5f5f5; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Order #{{ $order->id }}</h1>
        </div>
        <div class="content">
            <p>A new order has been placed.</p>
            <p><strong>Customer:</strong> {{ $order->customer_name ?? $order->user->name }}</p>
            <p><strong>Email:</strong> {{ $order->customer_email ?? $order->user->email }}</p>
            <p><strong>Phone:</strong> {{ $order->customer_phone ?? 'N/A' }}</p>
            <p><strong>Total:</strong> {{ format_currency($order->total_price) }}</p>
            <p><a href="{{ route('admin.orders.show', $order) }}">View Order</a></p>
        </div>
    </div>
</body>
</html>
