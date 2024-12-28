@extends('admin.layout.layout')
@section('content')
<section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-danger">
            <h4 class="card-title">Add your role</h4>
            <form class="forms-sample" action="{{route('role.store')}}" method="post" enctype="multipart/form-data" id="form">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName1">Name</label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="name" name="name">
                    <div class="error"> @error('name') {{$message}} @enderror</div>
                </div>
                <input type="checkbox" id="checkAll"> Select All

                <div class="checkbox-container">
                    @foreach($permission as $value)
                        <div class="checkbox-item">
                            <input type="checkbox" name="permissions[]" class="checkbox" value="{{$value->name}}">
                            <label for="permission">{{$value->name}}</label>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
        </div>
    </div>
</div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#checkAll').on('click', function() {
            $('.checkbox').prop('checked', this.checked);
        });

        $('.checkbox').on('click', function() {
            $('#checkAll').prop('checked', $('.checkbox:checked').length === $('.checkbox').length);
        });
    });
</script>

@endsection


