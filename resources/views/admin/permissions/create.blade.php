@extends('admin.layout.layout')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-danger">
            <h4 class="card-title">Add your permission</h4>
            <form class="forms-sample" action="{{route('permission.store')}}" method="post" enctype="multipart/form-data" id="form">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName1">Permission Name</label>
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="name" name="name" value="{{old('name')}}">
                    <div class="error"> @error('name') {{$message}} @enderror</div>
                </div>         
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="button" class="btn btn-secondary addFild">Add Permission</button>
            </form>
        </div>
    </div>
</div>
</section>

<script>
    $(document).ready(function() {
        $('.addFild').click(function() {
            // alert('hii');
            let Data = '<div class="div">\
            <div class="form-group mt-4">\
                    <label for="exampleInputName1">Permission Name</label>\
                    <input type="text" class="form-control" id="exampleInputName1" placeholder="name" name="PermissionName[]">\
            </div>\
            <button type="button" class="btn btn-secondary remove">Remove</button>\
                </div>';

                $('#form').append(Data);
        })
        $('#form').on('click','.remove',function(){
            // alert('hii')
            $(this).closest('.div').remove();
        })
    })
</script>

@endsection