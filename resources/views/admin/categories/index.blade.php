@extends('admin.layout.layout')
@section('content')
<div class="box">
    <div class="box-body">
        <h4 class="card-title">Categories List</h4>
        <!-- DataTable for displaying categories -->
        @can('category_create')
        <a href="{{route('category.create')}}" class="btn btn-success btn-rounded btn-fw">Add Category</a><br><br>
        @endcan
        <table id="categoriesTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Parent Category</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Show in Menu</th>
                    {{-- <th>URL Key</th> --}}
                    <th>Meta Tag</th>
                    <th>Meta Title</th>
                    {{-- <th>Meta Description</th>
                        <th>Short Description</th>
                        <th>Description</th> --}}
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
        $('#categoriesTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('category.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'parent_category',
                    name: 'parent_category'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'show_in_menu',
                    name: 'show_in_menu'
                },
                // { data: 'url_key', name: 'url_key' },
                {
                    data: 'meta_tag',
                    name: 'meta_tag'
                },
                {
                    data: 'meta_title',
                    name: 'meta_title'
                },
                // { data: 'meta_description', name: 'meta_description' },
                // { data: 'short_description', name: 'short_description' },
                // { data: 'description', name: 'description' },
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