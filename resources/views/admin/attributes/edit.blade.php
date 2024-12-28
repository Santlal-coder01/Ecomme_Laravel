@extends('admin.layout.layout')
@section('content')
<style>
    .error {
        color: red;
    }
    .update {
        margin-top: 10px;
    }
    .attribute-value-row {
        display: flex;
        justify-content: space-between;
    }
    .attribute-value-row .form-group {
        width: 44%;
    }
    .addFild {
  margin-top: 10px;
  height: 35px;
}
    .btn-danger {
  background-color: #dd4b39;
  border-color: #d73925;
  width: 100px;
  height: 38px;
  margin-top: 22px;
}
</style>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-danger">
                <h4 class="card-title">Add your attribute</h4>
                <form class="forms-sample" action="{{ route('attribute.update', $attribute->id) }}" method="post" enctype="multipart/form-data" id="form">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="exampleInputName">Name</label>
                        <input type="text" class="form-control" id="exampleInputName" placeholder="Name" name="name" value="{{ $attribute->name }}">
                        <div class="error">@error('name') {{ $message }} @enderror</div>
                    </div>
                    <!-- New field: Name Key -->
                    <div class="form-group">
                        <label for="exampleInputNameKey">Name Key</label>
                        <input type="text" class="form-control" id="exampleInputNameKey" placeholder="Name Key" name="name_key" value="{{ $attribute->name_key }}">
                        <div class="error">@error('name_key') {{ $message }} @enderror</div>
                    </div>
                    <!-- New field: Is Variant -->
                    <div class="form-group">
                        <label for="exampleInputIsVariant">Is Variant</label>
                        <select class="form-control" id="exampleInputIsVariant" name="is_variant">
                            <option value="0" {{ $attribute->is_variant == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ $attribute->is_variant == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
                        <div class="error">@error('is_variant') {{ $message }} @enderror</div>
                    </div>
                    <div class="form-group">
                        <label for="exampleSelectStatus">Status</label>
                        <select class="form-control" id="exampleSelectStatus" name="status">
                            <option value="">Select your status</option>
                            <option value="1" {{ $attribute->status == 1 ? 'selected' : '' }}>Enable</option>
                            <option value="2" {{ $attribute->status == 2 ? 'selected' : '' }}>Disable</option>
                        </select>
                        <div class="error">@error('status') {{ $message }} @enderror</div>
                    </div>
                    @if($attributevalues)
                    <h2>Attribute Values...</h2>
                    @foreach($attributevalues as $abv)
                    <div class="attribute-value-row">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Name" name="attributename[]" value="{{ $abv->name }}">
                            <div class="error">@error('name') {{ $message }} @enderror</div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="attributestatus[]">
                                <option value="">Select Status</option>
                                <option value="1" {{ $abv->status == 1 ? 'selected' : '' }}>Enable</option>
                                <option value="2" {{ $abv->status == 2 ? 'selected' : '' }}>Disable</option>
                            </select>
                            <div class="error">@error('status') {{ $message }} @enderror</div>
                        </div>
                        <button type="button" class="btn btn-danger remove">Remove</button>
                    </div>
                    @endforeach
                    @endif
           
                    <button type="submit" class="btn btn-primary update">Update</button>
                    <button type="button" class="btn btn-secondary addFild">Add Ab-V</button>
       
                </form>
            </div>
        </div>
    </div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#form').on('click', '.remove', function() {
            $(this).closest('.attribute-value-row').remove();
        });
   


    $('.addFild').click(function(){
            let htmlData = '<div>\
                                        <div class="form-group">\
                                            <label for="attributevalues">Name</label>\
                                            <input type="text" class="form-control" id="attributevalues" placeholder="attributevalues" name="attributename[]">\
                                        </div>\
                                        <div class="form-group">\
                                            <label for="attributestatus">Status</label>\
                                            <select class="form-control" id="attributestatus" name="attributestatus[]">\
                                                <option value="">Select Status</option>\
                                                <option value="1">Enable</option>\
                                                <option value="2">Disable</option>\
                                            </select>\
                                        </div>\
                                        <button type="button" class="btn btn-danger delete">Remove</button>\
                            </div>';
                            $('#form').append(htmlData);

                });
                $('#form').on('click','.delete',function(){
                    $(this).closest('div').remove();
                })

        });

</script>
@endsection
