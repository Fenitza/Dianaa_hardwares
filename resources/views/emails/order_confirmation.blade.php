<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Thank you for your order!</h1>
    <p>Your order has been successfully placed and is now being processed.</p>
    <strong>Order ID: {{ $order->order_id }} - Success</strong><br>
    <strong>Order Date: {{ $order->created_at->format('d M Y') }}</strong>

    <h2>Shipping Address</h2>
    <p>{{ $order->billing_address }}</p>

    <h2>Billing Address</h2>
    <p>{{ $order->billing_address }}</p>

    <h2>Payment Method</h2>
    <p>Pay On Delivery</p>

    <h2>Order Summary</h2>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->product->Name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>₹{{ number_format($item->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">Grand Total</td>
                <td>₹{{ number_format($order->total_amount, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
