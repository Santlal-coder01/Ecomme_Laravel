<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Invoice</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .invoice-header p {
            margin: 5px 0;
        }

        .section-title {
            background: #f8f8f8;
            padding: 10px;
            border: 1px solid #e0e0e0;
            margin-top: 20px;
            font-weight: bold;
        }

        .section-content {
            padding: 15px;
            border: 1px solid #e0e0e0;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .total-table th,
        .total-table td {
            font-weight: bold;
        }


        .address-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px; /* Spacing between items */
}

.address-box {
    flex: 1;
    min-width: 45%;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
}
body{
    font-family: 'DejaVu Sans', Arial, sans-serif;
}
    </style>
</head>

<body>

    <div class="container-fluid" id="container-wrapper">
        <h2 class="text-center">Your Order Details</h2>
        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="section-title">Order Information</div>
                                <div class="section-content">
                                    <p><strong>Order ID:</strong> {{ $order->id }}</p>
                                    {{-- @dd($order->id) --}}
                                    <p><strong>Order Date:</strong> {{ $order->created_at->format('d-M-Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="section-title">Account Information</div>
                                <div class="section-content">
                                    <p><strong>Customer Name:</strong> {{ $order->name }}</p>
                                    <p><strong>Email:</strong> {{ $order->email }}</p>
                                    {{-- @dd($order->email) --}}
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-title">Address Information</div>
                                <div class="section-content">
                                    <div class="address-container">
                                        @foreach ($order->addresses as $address)
                                        @if ($address->order_id == $order->id)
                                            <div class="address-box">
                                                <h4>{{ ucfirst($address->address_type) }} Address</h4>
                                                <p><strong>City:</strong> {{ $address->city }}</p>
                                                <p><strong>State:</strong> {{ $address->state }}</p>
                                                <p><strong>Country:</strong> {{ $address->country }}</p>
                                                <p><strong>PIN Code:</strong> {{ $address->pincode }}</p>
                                                <p><strong>Address:</strong> {{ $address->address }}</p>
                                                <p><strong>Address 2:</strong> {{ $address->address_2 }}</p>
                                            </div>
                                        @endif
                                        @endforeach
                                    </div>                                    
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-title">Payment & Shipping Method</div>
                                <div class="section-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4>Payment Information</h4>
                                            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <h4>Shipping Information</h4>
                                            <p><strong>Shipping Method:</strong> {{ $order->shipping_method }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-title">Items Ordered</div>
                                <div class="section-content">
                                    <div class="table-responsive">
                                        <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
                                            <thead>
                                                <tr>
                                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Image</th>
                                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Name</th>
                                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">SKU</th>
                                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Price</th>
                                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Qty</th>
                                                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($order->items as $item)
                                                    <tr>
                                                        <td style="border: 1px solid #ddd; padding: 8px;">
                                                            <img src="{{$item->product->getFirstMediaUrl('thumb_img')}}" alt="Product Image" width="50" height="50">
                                                        </td>   
                                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->name }}</td>
                                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->sku }}</td>
                                                        <td style="border: 1px solid #ddd; padding: 8px;">₹{{ number_format($item->price, 2) }}</td>
                                                        <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->qty }}</td>
                                                        <td style="border: 1px solid #ddd; padding: 8px;">₹{{ number_format($item->row_total, 2) }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" style="border: 1px solid #ddd; padding: 8px; text-align: center;">
                                                            No items found for this order.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="section-title">Order Total</div>
                                <div class="section-content">
                                    <table class="table table-bordered total-table">
                                        <tbody>
                                            <tr>
                                                <th>SubTotal:</th>
                                                {{-- @dd($order->sub_total) --}}
                                                <td>₹{{ number_format($order->sub_total, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Coupon:</th>
                                                <td>{{ $order->coupon }}</td>
                                            </tr>
                                            <tr>
                                                <th>Coupon Discount:</th>
                                                <td>-₹{{ number_format($order->coupon_discount, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping Cost:</th>
                                                <td>+₹{{ number_format($order->shipping_cost, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>₹{{ number_format($order->total, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /.col -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>