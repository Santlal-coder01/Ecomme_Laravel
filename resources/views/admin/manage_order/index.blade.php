@extends('admin.layout.layout')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    .pdf-icon {
        display: flex;
        align-items: center;
        font-size: 24px;
        color: #d32f2f;
        /* PDF red color */
        font-family: Arial, sans-serif;
    }

    .pdf-icon i {
        margin-right: 8px;
        font-size: 28px;
    }

    .pdf-icon span {
        font-weight: bold;
        font-size: 18px;
    }
</style>

<div class="box">
    <div class="box-body">
        <h4 class="card-title">Order List</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th> ID </th>
                    <th> Name </th>
                    <th> Email </th>
                    <th> Phone </th>
                    <th> Order Id </th>
                    <th> User ID </th>
                    <th> Shipping Cost </th>
                    <th> Total </th>
                    <th> Payment method </th>
                    <th> Shipping Method </th>
                    <th> Show order </th>
                    <th> Action </th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->order_increment_id }}</td>
                    <td>{{ $order->user_id }}</td>
                    <td>{{ $order->shipping_cost }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->shipping_method }}</td>
                    <td>
                        <a href="{{ route('order.show', $order->id) }}" class="btn btn-primary">Show</a>
                    </td>
                    <td>
                        <a href="{{ route('pdf.invoice',$order->id)}}" class="btn btn-secondory">
                            <div class="pdf-icon">
                                <i class="fas fa-file-pdf"></i>
                                <span>PDF</span>
                            </div>
                        </a>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection