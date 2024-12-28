@extends('admin.layout.layout')

@section('content')
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
<section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Add Slider</h3>
                </div>
                <form class="forms-sample" action="{{ route('slider.store') }}" method="post" enctype="multipart/form-data">
                    @csrf            
                    <!-- Title Field -->
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter page title" value="{{ old('title') }}">
                        <div class="error">@error('title') {{ $message }} @enderror</div>
                    </div>

                    <!-- URL Field -->
                    <div class="form-group">
                        <label for="url">URL</label>
                        <input type="text" class="form-control" id="url" name="url" placeholder="Enter URL" value="{{ old('url') }}">
                        <div class="error">@error('url') {{ $message }} @enderror</div>
                    </div>
                     <!-- img Field -->
                    <div class="form-group">
                        <label for="img">Image</label>
                        <input type="file" class="form-control" id="img" placeholder="Product Name" name="img">
                        <div class="error">@error('img') {{ $message }} @enderror</div>
                    </div>

                    <!-- Order Field -->
                    <div class="form-group">
                        <label for="order">Order</label>
                        <input type="number" class="form-control" id="order" name="order" placeholder="Enter order number" value="{{ old('order') }}">
                        <div class="error">@error('order') {{ $message }} @enderror</div>
                    </div>

                    <!-- Description Field -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="content" name="description" placeholder="Enter description">{{ old('description') }}</textarea>
                        <div class="error">@error('description') {{ $message }} @enderror</div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    ClassicEditor.create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
