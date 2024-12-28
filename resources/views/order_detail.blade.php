@extends('layout.layout')
@section('content')
<style>
    .card-body .row {
   display: flex
}

.card-body h5 {
    margin-bottom: 15px;
    text-transform: uppercase;
    font-weight: bold;
}
</style>
    <div class="container mt-5">
        <h1 class="text-center">Order Summary</h1>
        <div class="card mt-4">
            <div class="card-header bg-primary text-white">
                <h4>Order Details</h4>
                </div>
            <div class="card-body">
                <div class="row">
                    <!-- Billing Details Section -->
                    <div class="col-md-6">
                        <h5><strong>Billing Details</strong></h5>
                        <p><strong>Name:</strong> {{ $order->name }}</p>
                        <p><strong>Email:</strong> {{ $order->email }}</p>
                        <p><strong>Phone:</strong> {{ $order->phone }}</p>
                        <p><strong>Address Line 1:</strong> {{ $order->address }}</p>
                        <p><strong>Address Line 2:</strong> {{ $order->address_2 }}</p>
                        <p><strong>City:</strong> {{ $order->city }}</p>
                        <p><strong>State:</strong> {{ $order->state }}</p>
                        <p><strong>Country:</strong> {{ $order->country }}</p>
                        <p><strong>Pincode:</strong> {{ $order->pincode }}</p>
                    </div>
            
                    <!-- Shipping Details Section -->
                    <div class="col-md-6">
                        <h5><strong>Shipping Details</strong></h5>
                        <p><strong>Name:</strong> {{ $order->shipping_name ?? $order->name }}</p>
                        <p><strong>Email:</strong> {{ $order->shipping_email ?? $order->email }}</p>
                        <p><strong>Phone:</strong> {{ $order->shipping_phone ?? $order->phone }}</p>
                        <p><strong>Address Line 1:</strong> {{ $order->shipping_address ?? $order->address }}</p>
                        <p><strong>Address Line 2:</strong> {{ $order->shipping_address_2 ?? $order->address_2 }}</p>
                        <p><strong>City:</strong> {{ $order->shipping_city ?? $order->city }}</p>
                        <p><strong>State:</strong> {{ $order->shipping_state ?? $order->state }}</p>
                        <p><strong>Country:</strong> {{ $order->shipping_country ?? $order->country }}</p>
                        <p><strong>Pincode:</strong> {{ $order->shipping_pincode ?? $order->pincode }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Order Status Section -->
            <div class="card-body mt-4">
                <h5><strong>Order Status</strong></h5>
                <p><strong>Status:</strong> {{ $order->status }}</p>
            </div>
            
            <div class="card-body mt-4">
                <!-- Order Summary Section -->
                <h5><strong>Order Summary</strong></h5>
                <p><strong>Coupon Code:</strong> {{ $order->coupon ?? 'None' }}</p>
                <p><strong>Coupon Discount:</strong> ₹{{ number_format($order->coupon_discount, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                <p><strong>Shipping Method:</strong> {{ $order->shipping_method }}</p>
                <p><strong>Subtotal:</strong> ₹{{ number_format($order->sub_total, 2) }}</p>
                <p><strong>Shipping Cost:</strong> ₹{{ number_format($order->shipping_cost, 2) }}</p>
                <p><strong>Total:</strong> ₹{{ number_format($order->total, 2) }}</p>
            </div>
            
        </div>
        
        <h4>Order Items</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item) <!-- Iterating over order items -->
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>₹{{ number_format($item->price, 2) }}</td>
                    <td>₹{{ number_format($item->price * $item->qty, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('/') }}" class="btn btn-primary mt-3">Return to Home</a>
    </div>
@endsection
