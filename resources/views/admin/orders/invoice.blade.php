<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body { font-family: 'Courier New', monospace; font-size: 14px; line-height: 1.6; color: #333; padding: 40px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .header h1 { margin: 0; font-size: 28px; }
        .header p { margin: 5px 0; color: #666; }
        .info { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .info-box { width: 45%; }
        .info-box h4 { margin: 0 0 10px 0; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        .info-box p { margin: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #f5f5f5; font-weight: bold; }
        .text-end { text-align: right; }
        .total-row td { font-weight: bold; font-size: 16px; border-top: 2px solid #333; }
        .footer { text-align: center; margin-top: 40px; color: #999; font-size: 12px; border-top: 1px solid #ddd; padding-top: 20px; }
        @media print { body { padding: 0; } .no-print { display: none; } }
        .status { display: inline-block; padding: 4px 12px; border: 1px solid #333; font-size: 12px; }
    </style>
</head>
<body>
    <div class="no-print" style="text-align:right; margin-bottom:20px;">
        <button onclick="window.print()" class="btn btn-primary" style="padding:10px 20px;cursor:pointer;">
            🖨️ Print Invoice
        </button>
        <button onclick="window.close()" style="padding:10px 20px;cursor:pointer;">
            ✕ Close
        </button>
    </div>

    <div class="header">
        <h1>{{ website_setting('website_name', config('app.name')) }}</h1>
        <p>Invoice</p>
    </div>

    <div class="info">
        <div class="info-box">
            <h4>Bill To</h4>
            <p><strong>{{ $order->customer_name ?? $order->user->name }}</strong></p>
            <p>{{ $order->customer_email ?? $order->user->email }}</p>
            <p>{{ $order->customer_phone }}</p>
            <p>{{ $order->customer_address ?? $order->shipping_address }}</p>
            @if($order->customer_city) <p>City: {{ $order->customer_city }}</p> @endif
            @if($order->postal_code) <p>Postal Code: {{ $order->postal_code }}</p> @endif
        </div>
        <div class="info-box" style="text-align:right">
            <h4>Order Details</h4>
            <p><strong>Invoice #:</strong> INV-{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Order #:</strong> {{ $order->id }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('F d, Y') }}</p>
            <p><strong>Status:</strong> <span class="status">{{ ucfirst($order->status) }}</span></p>
            <p><strong>Payment:</strong> {{ $order->payment->payment_method ?? 'N/A' }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:60%">Product</th>
                <th class="text-end">Price</th>
                <th class="text-end">Qty</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->name ?? 'Deleted Product' }}</td>
                <td class="text-end">{{ format_currency($item->price) }}</td>
                <td class="text-end">{{ $item->quantity }}</td>
                <td class="text-end">{{ format_currency($item->price * $item->quantity) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end">Subtotal:</td>
                <td class="text-end">{{ format_currency($order->total_price - $order->delivery_charge) }}</td>
            </tr>
            @if($order->delivery_charge > 0)
            <tr>
                <td colspan="3" class="text-end">Delivery Charge ({{ $order->delivery_area }}):</td>
                <td class="text-end">{{ format_currency($order->delivery_charge) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td colspan="3" class="text-end">Total:</td>
                <td class="text-end">{{ format_currency($order->total_price) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>{{ website_setting('footer_text', '© 2026 IMMI. All rights reserved.') }}</p>
    </div>

    <script>
        window.onload = function() {
            // Auto-print if URL contains ?print=1
            const params = new URLSearchParams(window.location.search);
            if (params.get('print') === '1') setTimeout(function() { window.print(); }, 500);
        };
    </script>
</body>
</html>
