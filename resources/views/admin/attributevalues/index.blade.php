@extends('admin.layout.layout')
@section('content')

<div class="box">
  <div class="box-body">
    <a href="{{route('attribute-values.create')}}" class="btn btn-success btn-rounded btn-fw">Add Ab-V</a><br><br>
    <table class="table table-bordered table-striped data-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Attribute ID</th>
          <th>Name</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
<script type="text/javascript">
  $(function() {
    var table = $('.data-table').DataTable({
      processing: true,
      serverSide: true,
      paging: true,
      lengthChange: false,
      searching: true,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true,
      ajax: "{{ route('attribute-values.index') }}",
      columns: [{
          data: 'id',
          name: 'id'
        },
        {
          data: 'attribute_id',
          name: 'attribute_id'
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