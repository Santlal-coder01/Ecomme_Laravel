@extends('admin.layout.layout')
@section('content')
<style>
    /* Order Page Custom Styles */
.btn-primary {
    float: right;
    margin-bottom: 20px;
}

.section-title {
    font-weight: 600;
    margin-bottom: 10px;
}

.hr-strong {
    margin: 10px 0;
    border-width: 2px;
}

.table-bordered th, .table-bordered td {
    vertical-align: middle;
    text-align: center;
    padding: 8px;
}

.table-bordered th {
    background-color: #f8f9fa;
    font-weight: bold;
}

.address-box {
    padding: 10px;
    border: 1px solid #ddd;
    margin-bottom: 20px;
    background: #f9f9f9;
    border-radius: 4px;
}

.custom-options ul {
    list-style: none;
    padding: 0;
}

.custom-options ul li {
    margin: 5px 0;
}
</style>

<div class="box">

    <div class="box-body">
        <a href="{{route('order_list')}}" class="btn btn-primary" style="float: right;">Order List</a>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <h3 style="font-weight:600;">Order Information</h3>
                <hr style="margin: 0; border-width:2px;">
                <h4><strong> Order ID :</strong> {{ $order->id }}</h4>
                <h4><strong>Order Date:</strong> {{ $order->created_at->format('d-M-Y') }}</h4>
            </div>
            <div class="col-md-6">
                <h3 style="font-weight:600;">Account Information</h3>
                <hr style="margin: 0; border-width:2px;">
                <h4><strong>Customer name:</strong> {{ $order->name }}</h4>
                <h4><strong>Email:</strong> {{ $order->email }}</h4>
            </div>
        </div>
        <br><br>
        <div class="row">
            <div class="col-md-12">

                <h3 style="font-weight:600;">Address Information</h3>
                <hr style="margin: 0; border-width:2px;">

                {{-- @dd($order); --}}
                @foreach ($order->addresses as $address)
                <div class="row">
                    @if ($address->address_type == 'billing_address')
                    <div class="row address-box">
                        <div class="col-md-6">
                            <h4 class="section-title">Billing Address</h4>
                            <p><strong>City:</strong> {{ $address->city }}</p>
                            <p><strong>State:</strong> {{ $address->state }}</p>
                            <p><strong>Country:</strong> {{ $address->country }}</p>
                            <p><strong>PIN Code:</strong> {{ $address->pincode }}</p>
                            <p><strong>Address:</strong> {{ $address->address }}</p>
                            <p><strong>Address 2:</strong> {{ $address->address2 }}</p>
                        </div>
                    </div>
                    
                    @endif
                    @if ($address->address_type == 'shipping_address')
                    <div class="col-md-6">
                        <h4 style="font-weight:600;">Shipping Address</h4>

                        <p><strong>City:</strong> {{ $address->city }}</p>
                        <p><strong>State:</strong> {{ $address->state }}</p>
                        <p><strong>Country:</strong> {{ $address->country }}</p>
                        <p><strong>PIN Code:</strong> {{ $address->pincode }}</p>
                        <p><strong>Address:</strong> {{ $address->address }}</p>
                        <p><strong>Address 2:</strong>{{ $address->address2 }} </p>
                    </div>
                    @endif
                </div>
                @endforeach

            </div>

        </div>

        <br><br>
        <div class="row">
            <div class="col-md-12">

                <h3 style="font-weight:600;">Payment & Shipping Method</h3>
                <hr style="margin: 0; border-width:2px;">

                <div class="row">
                    <div class="col-md-6">
                        <h4 style="font-weight:600;">Payment Information</h4>
                        <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>

                    </div>
                    <div class="col-md-6">
                        <h4 style="font-weight:600;">Shipping Information</h4>
                        <p><strong>Shipping Method:</strong> {{ $order->shipping_method }}</p>

                    </div>
                </div>

            </div>

        </div>

        <br><br>
        <div class="row">
            <div class="col-md-12">

                <h3 style="font-weight:600;">Item Ordered</h3>
                <hr style="margin: 0; border-width:2px;">

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Product</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Row Total</th>
                            <th>Custom Option</th>
                        </tr>
                        @foreach ($order->items as $item)
                        <tr>
                            <td><img src="{{ $item->product->getFirstMediaUrl('thumb_img') }}" alt="" width="50px" height="50px"></td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->sku }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>{{ $item->row_total }}</td>
                            <td>
                                @if ($item->custom_option)
                                @php
                                    $jsonDecode = json_decode($item->custom_option, true);
                                    // dd($jsonDecode);
                                    if (is_string($jsonDecode)) {
                                    $options = json_decode($jsonDecode, true);
                                // dd($options);
                                    } else {
                                        $options = $jsonDecode;
                                    }
                                @endphp
                             <ul class="custom-options">
                            @foreach ($options as $key => $value)
                                <li class="custom-option-item">
                                    <strong>{{ $key }}:</strong>
                                    <span>{{ $value }}</span>
                                </li>
                            @endforeach
                        </ul>
                            @endif
                        
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                

            </div>

        </div>

        <br><br>
        <div class="row">
            <div class="col-md-12">

                <h3 style="font-weight:600;">Order Total</h3>
                <hr style="margin: 0; border-width:2px;">
                <div class="col-md-6">

                </div>
                <div class="col-md-6">
                    <h3 style="font-weight:600;">Account Information</h3>
                    <hr style="margin: 0; border-width:2px;">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>SubTotal:</th>
                                <td>{{ number_format($order->sub_total, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Coupon:</th>
                                <td>{{ $order->coupon }}</td>
                            </tr>

                            <tr>
                                <th>Coupon Discount:</th>
                                <td>-{{ number_format($order->coupon_discount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Shipping Cost:</th>
                                <td>+{{ number_format($order->shipping_cost, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td>{{ number_format($order->total, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        @endsection