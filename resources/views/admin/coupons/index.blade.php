@extends('admin.layout.layout')
@section('content')
<div class="box">
    <div class="box-body">
        <h4 class="card-title">Coupons List</h4>

        <!-- Check if user can create a coupon -->
        @can('coupon_create')
        <a href="{{ route('coupon.create') }}" class="btn btn-success btn-rounded btn-fw">Add Coupon</a><br><br>
        @endcan

        <!-- DataTable for displaying coupons -->
        <table id="couponsTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Coupon Code</th>
                    <th>Status</th>
                    <th>Valid From</th>
                    <th>Valid To</th>
                    <th>Discount Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows populated by DataTable script -->
            </tbody>
        </table>
    </div>
</div>

<!-- DataTables Script -->

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function() {
        $('#couponsTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('coupon.index') }}", // Adjust route to coupon.index
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'coupon_code',
                    name: 'coupon_code'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'valid_from',
                    name: 'valid_from'
                },
                {
                    data: 'valid_to',
                    name: 'valid_to'
                },
                {
                    data: 'discount_amount',
                    name: 'discount_amount'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endsection