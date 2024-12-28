@extends('admin.layout.layout')

@section('content')
<div class="box">
    <div class="box-body">
        <h4 class="card-title">Coupon Details</h4>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $coupon->id }}</td>
                    </tr>
                    <tr>
                        <th>Title</th>
                        <td>{{ $coupon->title }}</td>
                    </tr>
                    <tr>
                        <th>Coupon Code</th>
                        <td>{{ $coupon->coupon_code }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $coupon->status == 1 ? 'Active' : 'Inactive' }}</td>
                    </tr>
                    <tr>
                        <th>Valid From</th>
                        <td>{{ $coupon->valid_from }}</td>
                    </tr>
                    <tr>
                        <th>Valid To</th>
                        <td>{{ $coupon->valid_to }}</td>
                    </tr>
                    <tr>
                        <th>Discount Amount</th>
                        <td>{{ $coupon->discount_amount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <a href="{{ route('coupon.index') }}" class="btn btn-secondary">Back to List</a>
        <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-primary">Edit Coupon</a>
        <form action="{{ route('coupon.destroy', $coupon->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this coupon?');">Delete</button>
        </form>
    </div>
</div>
@endsection
