@extends('layout.layout')
@section('content')
<style>
    .custom_report {
        display: flex;
        width: 100%;
    }
</style>
<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('/') }}">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shopping Cart</p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Flash Message -->
{{-- @if ($message)
    <div class="alert alert-success text-center">
        {{ $message }}
</div>
@endif --}}

@if (session('message'))
<div class="alert alert-info text-center">
    {{ session('message') }}
</div>
@endif

<!-- Cart Start -->
<!-- Cart Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @if ($quotes && $quotes->count())
                    @foreach($quotes as $item)
                    <tr>
                        <td class="align-middle">
                            <img src="{{ $item->product->getFirstMediaUrl('thumb_img') }}" alt="" style="width: 50px;">
                            {{ $item->product->name }}
                        </td>
                        <td class="align-middle">
                            ₹
                            @if ($item->product->special_price && now()->between($item->product->special_price_from,
                            $item->product->special_price_to))
                            {{ $item->product->special_price }}
                            <small class="text-muted">({{ $item->product->price }})</small>
                            @else
                            {{ $item->product->price }}
                            @endif
                        </td>
                        <td class="align-middle custom_report">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="cart-update-form"
                                style="display: inline;">
                                @csrf
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary btn-minus">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text"
                                        class="form-control form-control-sm bg-secondary text-center qty-input"
                                        name="qty" value="{{ $item->qty }}" data-item-id="{{ $item->id }}">
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-sm btn-success custom-update btn-update"
                                    style="display: none;" data-item-id="{{ $item->id }}">Update</button>
                            </form>
                        </td>
                        <td class="align-middle">₹
                            @if ($item->product->special_price && now()->between($item->product->special_price_from,
                            $item->product->special_price_to))
                            {{ $item->product->special_price * $item->qty }}
                            @else
                            {{ $item->product->price * $item->qty }}
                            @endif
                        </td>
                        <td class="align-middle">
                            <form method="POST" action="{{ route('cart.remove', $item->id) }}">
                                @csrf
                                <button class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="5" class="text-center">Your cart is empty!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Cart Summary -->
        <!-- Cart Summary -->
       
        @php
        $newSubtotal = collect($quotes)->reduce(function ($carry, $item) {
            if ($item->product->special_price && now()->between($item->product->special_price_from, $item->product->special_price_to)) {
                return $carry + ($item->product->special_price * $item->qty);
            } else {
                return $carry + ($item->product->price * $item->qty);
            }
        }, 0);
        
        $shippingCost = 0; // Example static value, can be dynamic.
        $total = ($newSubtotal + $shippingCost) - ($quote->coupon_discount ?? 0);
        @endphp
        

        <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Subtotal</h6>
                        <h6 class="font-weight-medium">₹<span id="subtotal">{{ $newSubtotal }}</span></h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Shipping</h6>
                        <h5 class="font-weight-bold">₹<span id="shipping">{{ $shippingCost }}</span></h5>
                    </div>
                    @if ($quote && $quote->coupon_discount > 0)
                    <div class="d-flex justify-content-between" id="coupon-section">
                        <h6 class="font-weight-medium">Coupon Discount</h6>
                        <h6 class="font-weight-medium">-₹<span id="coupon-discount">{{ $quote->coupon_discount }}</span></h6>
                    </div>
                    @endif
                </div>
                <form action="{{route('checkout')}}" method="GET">
                    {{-- @csrf --}}
                    {{-- <input type="hidden" id="cart_id" name="cart_id" value="{{$quote->cart_id}}"> --}}
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">₹<span id="total">{{ $total }}</span></h5>
                        </div>
                        <button type="submit" class="btn btn-block btn-primary my-3 py-3">Proceed To Checkout</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Coupon Form -->
        <!-- Coupon Section -->

        <!-- Coupon Form -->
        <div class="coupon_cart" style="width: 30%;">
            @if ($quote && $quote->coupon)
            <form method="POST" action="{{ route('cart.removeCoupon') }}">
                @csrf
                <p><b>Applied Coupon:</b> {{ $quote->coupon }}</p>
                <button class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Remove</button>
            </form>
            @else
            <form action="{{ route('cart.applyCoupon') }}" method="POST" id="coupon-form">
                @csrf
                <input type="text" placeholder="Coupon code" id="coupon" name="coupon_code" class="coller"
                    style="height: 35px; width: 80%;" value="">
                <button type="submit" class="btn btn-success"
                    style="border-radius: 29px; height: 40px; margin-bottom: 3px; margin-left: -30px;">
                    Apply
                </button>
            </form>
            @endif
        </div>

    </div>
</div>
<!-- Cart End -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Show the Update button when quantity is changed
        document.querySelectorAll(".qty-input").forEach((input) => {
            input.addEventListener("input", function() {
                const itemId = this.dataset.itemId;
                const updateButton = document.querySelector(
                    `.btn-update[data-item-id="${itemId}"]`);
                if (updateButton) {
                    updateButton.style.display = "block"; // Show the Update button
                }
            });
        });
        // Handle plus and minus button clicks
        document.querySelectorAll(".btn-plus, .btn-minus").forEach((button) => {
            button.addEventListener("click", function() {
                const isPlus = this.classList.contains("btn-plus");
                const qtyInput = this.closest(".quantity").querySelector(".qty-input");
                let currentQty = parseInt(qtyInput.value) || 0;
                // Update quantity based on button click
                if (isPlus) {
                    currentQty += 0; // Increment quantity
                } else {
                    currentQty = Math.max(currentQty - 0,
                        1); // Decrement quantity, ensuring it doesn't go below 1
                }
                qtyInput.value = currentQty; // Update the input field value
                qtyInput.dispatchEvent(new Event(
                    "input")); // Trigger input event to show the Update button
            });
        });
        // Handle the form submission for updating the cart
        document.querySelectorAll(".btn-update").forEach((button) => {
            button.addEventListener("click", function() {
                const form = this.closest("form");
                form.submit(); // Submit the form to update the cart
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Update subtotal and total
        function updateCartTotals() {
            let subtotal = 0;
            document.querySelectorAll(".align-middle .qty-input").forEach((input) => {
                const price = parseFloat(input.closest("tr").querySelector(".price").textContent
                    .replace("₹", "")) || 0;
                const qty = parseInt(input.value) || 0;
                subtotal += price * qty;
            });
            const totalElement = document.getElementById("total");
            const subtotalElement = document.getElementById("subtotal");
            if (subtotalElement) subtotalElement.textContent = subtotal.toFixed(2);
            if (totalElement) totalElement.textContent = subtotal.toFixed(2); // Adjust for shipping/coupons
        }
        document.querySelectorAll(".qty-input").forEach((input) => {
            input.addEventListener("input", updateCartTotals);
        });
        updateCartTotals(); // Initial calculation
    });
</script>

@endsection