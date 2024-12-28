@extends('admin.layout.layout')

@section('content')

{{-- <h1>WELCOME USERS TABLE</h1> --}}
<div class="box">
    <div class="box-body">
        <h4 class="card-title">Users Table</h4>
        <h3><a href="{{route('user.create')}}" class="btn btn-success btn-rounded btn-fw">Add User</a></h3>

        <table class="table table-striped data-table table-container">
            <thead>
                <tr>
                    <th> User Id </th>
                    <th> Name</th>
                    <th> Email </th>
                    <th>Roles</th>
                    <th>Image</th>
                    {{-- <th> Contact No.</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach($user as $key => $usr)
                    <tr>
                        <td>{{$usr->id}}</td>
                <td>{{$usr->name}}</td>
                <td>{{$usr->email}}</td>
                <td>{{$usr->contact}}</td>
                <td><a class="btn btn-primary" href="{{route('user.edit',$usr->id)}}">Edit</a>
                    <form action="{{route('user.destroy',$usr->id)}}" style="display:inline;" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="margin-left: 0%">Delete</button>
                    </form>
                </td>
                </tr>
                @endforeach --}}
            </tbody>
        </table>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'roles',
                    name: 'roles'
                },
                {
                    data: 'image',
                    name: 'image'
                },
                //   {data: 'contact', name: 'contact'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>
@endsection