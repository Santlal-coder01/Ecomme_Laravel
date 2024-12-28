@extends('layout.layout')
@section('content')
<style>
    .order-success-container {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 80vh; /* Adjust based on your layout */
    /* background-color: #f8f9fa; Light gray background */
    /* margin-top: 100px; */
    /* margin-bottom: 150px; */
}

.order-success-content {
    max-width: 600px;
    background: #ffffff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 30px;
}

.order-success-image {
    max-width: 100%;
     height: auto;
     margin-bottom: 20px;
     width: 200px;
}

.order-success-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 10px;
    color: #333333;
}

.order-success-message {
    font-size: 16px;
    color: #555555;
    margin-bottom: 30px;
}

.order-success-actions a {
    margin: 0 10px;
    padding: 10px 20px;
    text-decoration: none;
    font-size: 16px;
    font-weight: 500;
}

.order-success-actions .btn-primary {
    background-color: #007bff;
    color: #ffffff;
    border: none;
    border-radius: 5px;
}

.order-success-actions .btn-primary:hover {
    background-color: #0056b3;
}

.order-success-actions .btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
    border-radius: 5px;
}

.order-success-actions .btn-outline-secondary:hover {
    background-color: #6c757d;
    color: #ffffff;
}

</style>
<div class="order-success-container">
    <div class="order-success-content text-center">
        <img src="{{ asset('assets/img/order_place_successfull.webp') }}" alt="Order Successful" class="order-success-image">
        <h2 class="order-success-title">Thank You for Your Order!</h2>
        <p class="order-success-message">Your order has been successfully placed. You will receive an email confirmation shortly.</p>
        <div class="order-success-actions">
            <a href="{{ route('/') }}" class="btn btn-primary btn-lg">Continue Shopping</a>
            <a href="#" class="btn btn-outline-secondary btn-lg">Order Details</a>
        </div>
    </div>
</div>
@endsection
