@extends('admin.layout.layout')
@section('content')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>  

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
<div class="box">
    <div class="box-body">
            <h4 class="card-title">Blocks List</h4>
            <a href="{{route('block.create')}}" class="btn btn-success btn-rounded btn-fw">Add Block</a><br><br>
            <table border="2pt" class="table table-hover data-table">
                <thead>
                    <tr>
                        <th> Id </th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th> Action </th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>


<script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('block.index') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'b_image', name: 'b_image' },
                { data: 'status', name: 'status' },
              
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endsection
