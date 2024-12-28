@extends('admin.layout.layout')
@section('content')
<style>
    .error {
        color: red;
    }
</style>
<section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-danger">
            <h4 class="card-title">Add your attribute</h4>
            <form class="forms-sample" action="{{ route('attribute.store') }}" method="post" enctype="multipart/form-data" id="form" class="form">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName">Name</label>
                    <input type="text" class="form-control" id="exampleInputName" placeholder="Name" name="name">
                    <div class="error">@error('name') {{ $message }} @enderror</div>
                </div>

                <!-- New field: Name Key -->
                <div class="form-group">
                    <label for="exampleInputNameKey">Name Key</label>
                    <input type="text" class="form-control" id="exampleInputNameKey" placeholder="Name Key" name="name_key">
                    <div class="error">@error('name_key') {{ $message }} @enderror</div>
                </div>

                <!-- New field: Is Variant -->
                <div class="form-group">
                    <label for="exampleInputIsVariant">Is Variant</label>
                    <select class="form-control" id="exampleInputIsVariant" name="is_variant">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                    <div class="error">@error('is_variant') {{ $message }} @enderror</div>
                </div>

                <div class="form-group">
                    <label for="exampleSelectStatus">Status</label>
                    <select class="form-control" id="exampleSelectStatus" name="status">
                        <option value="">Select your status</option>
                        <option value="1">Enable</option>
                        <option value="2">Disable</option>
                    </select>
                    <div class="error">@error('status') {{ $message }} @enderror</div>
                </div>
                <!-- Rest of the fields remain unchanged -->
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                <button type="button" class="btn btn-secondary mr-2 addFild">Add Ab-V</button>
            </form>
        </div>
    </div>
</div>
</section>

{{-- <script>
    ClassicEditor.create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });
</script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script><script>
    $(document).ready(function(){
        $('.addFild').click(function(){
            let htmlData ='         <div class="form-group mb-2">\
                                            <label for="attributevalues">Name</label>\
                                            <input type="text" class="form-control" id="attributevalues" placeholder="attributevalues" name="av[]">\
                                        </div>\
                                        <div class="form-group mb-2">\
                                            <label for="attributestatus">Status</label>\
                                            <select class="form-control" id="attributestatus" name="as[]">\
                                                <option value="">Select Status</option>\
                                                <option value="1">Enable</option>\
                                                <option value="2">Disable</option>\
                                            </select>\
                                        </div>\
                                        <button type="button" class="btn btn-danger remove">Remove</button>'\
                            $('#form').append(htmlData);

                });
                $('#form').on('click','.remove',function(){
                    $(this).closest('div').remove();
                })

        });

</script>
@endsection
