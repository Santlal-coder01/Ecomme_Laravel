@extends('admin.layout.layout')
@section('content')
<style>
    .error {
        color: red;
    }
</style>
<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-danger">
            <h4 class="card-title">Add your page</h4>
            <form class="forms-sample" action="{{ route('page.store') }}" method="post" enctype="multipart/form-data" id="form">
                @csrf
                <div class="form-group">
                    <label for="exampleInputName">Name</label>
                    <input type="text" class="form-control" id="exampleInputName" placeholder="Name" name="name">
                    <div class="error">@error('name') {{ $message }} @enderror</div>
                </div>
                <div class="form-group">
                    <label for="img">Image</label>
                    <input type="file" class="form-control" id="img" placeholder="Product Name" name="img">
                    <div class="error">@error('img') {{ $message }} @enderror</div>
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
                <div class="form-group">
                    <label>Show in Menu</label>
                    <select class="form-control" name="show_in_menu">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                    <div class="error">@error('show_in_menu') {{ $message }} @enderror</div>
                </div>
                <div class="form-group">
                    <label>Show in Footer</label>
                    <select class="form-control" name="show_in_footer">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                    <div class="error">@error('show_in_footer') {{ $message }} @enderror</div>
                </div>
                {{-- <div class="form-group">
                    <label for="exampleInputUrlKey">URL Key</label>
                    <input type="text" class="form-control" id="exampleInputUrlKey" placeholder="URL Key" name="url_key">
                    <div class="error">@error('url_key') {{ $message }} @enderror</div>
                </div> --}}
                 <div class="form-group">
                    <label for="exampleInputDescription">Description</label>
                    <textarea class="form-control" id="content" placeholder="Description" name="description" rows="3"></textarea>
                    <div class="error">@error('description') {{ $message }} @enderror</div>
                </div>
                <div class="form-group">
                    <label for="exampleInputMetaTag">Meta Tag</label>
                    <input type="text" class="form-control" id="exampleInputMetaTag" placeholder="Meta Tag" name="meta_tag">
                    <div class="error">@error('meta_tag') {{ $message }} @enderror</div>
                </div>
                <div class="form-group">
                    <label for="exampleInputMetaTitle">Meta Title</label>
                    <input type="text" class="form-control" id="exampleInputMetaTitle" placeholder="Meta Title" name="meta_title">
                    <div class="error">@error('meta_title') {{ $message }} @enderror</div>
                </div>
                <div class="form-group">
                    <label for="exampleInputMetaDescription">Meta Description</label>
                    <textarea class="form-control" id="exampleInputMetaDescription" placeholder="Meta Description" name="meta_description" rows="3"></textarea>
                    <div class="error">@error('meta_description') {{ $message }} @enderror</div>
                </div>

                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
        </div>
    </div>
</div>
</section>

<script>
  CKEDITOR.replace('description')
</script>
@endsection
