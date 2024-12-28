@extends('layout.layout')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Admin Profile</h2>
        <div class="row">
            <!-- User Info Section -->
            <div class="col-md-6">
                <h4>Update Details</h4>
                <form action="{{ route('update_profile') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}">
                    </div>
                    {{-- <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" value="{{ Auth::user()->phone }}">
                    </div> --}}
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>

            <!-- Change Password Section -->
            <div class="col-md-6">
                <h4>Change Password</h4>
                <form action="{{ route('change_password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" name="new_password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="con_new_password" class="form-label">Confirm New Password</label>
                        <input type="password" name="con_new_password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>

        <!-- User Orders Section -->
        <div class="mt-5">
            <h4>Order History</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->total }}</td>
                        <td>Processing</td>
                        <td><a href="{{ route('order_detail', $order->id) }}" class="btn btn-sm btn-info">View</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Address Section -->
        {{-- <div class="mt-4">
            <h4>Saved Addresses</h4>
            <ul class="list-group">
                @foreach($address as $addr)
                <li class="list-group-item">{{ $addr->address }}</li>
                @endforeach
            </ul>
        </div> --}}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection