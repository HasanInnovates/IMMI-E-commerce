<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #08a59b; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .details { margin-bottom: 20px; }
        .details label { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #f5f5f5; }
        .total { font-size: 18px; font-weight: bold; text-align: right; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Order Confirmed!</h1>
        </div>
        <div class="content">
            <p>Dear {{ $order->customer_name ?? $order->user->name }},</p>
            <p>Thank you for your order. Your order has been placed successfully.</p>

            <div class="details">
                <p><label>Order ID:</label> #{{ $order->id }}</p>
                <p><label>Order Date:</label> {{ $order->created_at->format('F d, Y') }}</p>
                <p><label>Status:</label> {{ ucfirst($order->status) }}</p>
            </div>

            <h3>Items Ordered</h3>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td>{{ $item->product->name ?? 'Product' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ format_currency($item->price) }}</td>
                        <td>{{ format_currency($item->price * $item->quantity) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                @if($order->delivery_charge > 0)
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right"><strong>Delivery Charge:</strong></td>
                        <td>{{ format_currency($order->delivery_charge) }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" style="text-align:right"><strong>Total:</strong></td>
                        <td><strong>{{ format_currency($order->total_price) }}</strong></td>
                    </tr>
                </tfoot>
                @else
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align:right"><strong>Total:</strong></td>
                        <td><strong>{{ format_currency($order->total_price) }}</strong></td>
                    </tr>
                </tfoot>
                @endif
            </table>

            <div class="details">
                <h3>Shipping Address</h3>
                <p>{{ $order->shipping_address }}</p>
                @if($order->customer_city)
                    <p>City: {{ $order->customer_city }}</p>
                @endif
                @if($order->postal_code)
                    <p>Postal Code: {{ $order->postal_code }}</p>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
