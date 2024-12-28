@extends('admin.layout.layout')
@section('content')
<section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-danger">
            <h4 class="card-title">Add Category</h4>
            <form class="forms-sample" action="{{ route('category.store') }}" method="post" id="form" enctype="multipart/form-data">
                @csrf

                <!-- Parent Category Field -->
                <div class="form-group">
         
                    <label for="exampleInputParentCategory">Parent Category</label>
                    <select class="form-control" id="exampleInputParentCategory" name="parent_category">
                        <option value="0">Select Parent Category</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <div class="error">@error('parent_category') {{ $message }} @enderror</div>
                </div>
                <div class="form-group">
                    <label for="Products">Products</label>
                    <select class="form-control" id="Products" name="related_products[]" multiple>
                        <option value="0">Select Products</option>
                        @foreach ($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>
                    <div class="error">@error('related_products') {{ $message }} @enderror</div>
                </div>
                <!-- Name Field -->
                <div class="form-group">
                    <label for="exampleInputName">Name</label>
                    <input type="text" class="form-control" id="exampleInputName" placeholder="Enter name" name="name">
                    <div class="error">@error('name') {{ $message }} @enderror</div>
                </div>

                <!-- Status Field -->
                <div class="form-group">
                    <label for="exampleSelectStatus">Status</label>
                    <select class="form-control" id="exampleSelectStatus" name="status">
                        <option value="">Select Status</option>
                        <option value="1">Enable</option>
                        <option value="2">Disable</option>
                    </select>
                    <div class="error">@error('status') {{ $message }} @enderror</div>
                </div>

                <!-- Show in Menu Field -->
                <div class="form-group">
                    <label for="exampleSelectShowInMenu">Show in Menu</label>
                    <select class="form-control" id="exampleSelectShowInMenu" name="show_in_menu">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                    <div class="error">@error('show_in_menu') {{ $message }} @enderror</div>
                </div>

                <!-- URL Key Field -->
                {{-- <div class="form-group">
                    <label for="exampleInputUrlKey">URL Key</label>
                    <input type="text" class="form-control" id="exampleInputUrlKey" placeholder="URL Key" name="url_key">
                    <div class="error">@error('url_key') {{ $message }} @enderror</div>
                </div> --}}

                <!-- Meta Tag Field -->
                <div class="form-group">
                    <label for="exampleInputMetaTag">Meta Tag</label>
                    <input type="text" class="form-control" id="exampleInputMetaTag" placeholder="Meta Tag" name="meta_tag">
                    <div class="error">@error('meta_tag') {{ $message }} @enderror</div>
                </div>

                <!-- Meta Title Field -->
                <div class="form-group">
                    <label for="exampleInputMetaTitle">Meta Title</label>
                    <input type="text" class="form-control" id="exampleInputMetaTitle" placeholder="Meta Title" name="meta_title">
                    <div class="error">@error('meta_title') {{ $message }} @enderror</div>
                </div>

                <!-- Meta Description Field -->
                <div class="form-group">
                    <label for="exampleInputMetaDescription">Meta Description</label>
                    <textarea class="form-control" id="exampleInputMetaDescription" placeholder="Meta Description" name="meta_description" rows="3"></textarea>
                    <div class="error">@error('meta_description') {{ $message }} @enderror</div>
                </div>

                <!-- Short Description Field -->
                <div class="form-group">
                    <label for="exampleInputShortDescription">Short Description</label>
                    <textarea class="form-control" id="exampleInputShortDescription" placeholder="Short Description" name="short_description" rows="2"></textarea>
                    <div class="error">@error('short_description') {{ $message }} @enderror</div>
                </div>

                <!-- Description Field -->
                <div class="form-group">
                    <label for="description">Description</label>
                        <div class='box-body pad'>
                            <textarea id="description" name="description" rows="10" cols="80">{{ old('description') }}</textarea>
                        </div>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
    

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
        </div>
    </div>
    </div>
</section>
{{-- <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script> --}}

<script src="//cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
