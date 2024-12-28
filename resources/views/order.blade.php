@extends('layout.layout')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Your Orders</h1>

    @if($orders->isEmpty())
        <p class="text-center">You have no orders yet.</p>
    @else
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                    <td>Processing</td>
                    <td>₹{{ number_format($order->total, 2) }}</td>
                    <td>
                        <a href="{{ route('order.success', $order->id) }}" class="btn btn-info">View Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
