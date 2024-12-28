@extends('admin.layout.layout')
@section('content')
<style>
    .error {
        color: red;
    }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>


<section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-danger">
            <h4 class="card-title">Add Product</h4>
            <form class="forms-sample" action="{{ route('product.update',$product->id) }}" method="post" enctype="multipart/form-data" id="productForm">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="related_product">Related Products</label>
                    <select name="related_product[]" id="related_product" class="form-control" multiple>
                        <option value="">Select Related Product</option>
                        @foreach ($all_products as $item)
                        <option value="{{ $item->id }}" 
                            {{ in_array($item->id, (array) $product->id ?? []) ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Product Name" name="name" value="{{$product->name}}">
                    <div class="error">@error('name') {{ $message }} @enderror</div>
                </div>

                <!-- Status Field -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">Select Status</option>
                        <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Enable</option>
                        <option value="2" {{ $product->status == 2 ? 'selected' : '' }}>Disable</option>
                    </select>
                    <div class="error">@error('status') {{ $message }} @enderror</div>
                </div>
                <div class="form-group"> 
                    <label for="banner_image">Banner Image</label><br>
                    @foreach($product->getMedia('banner_images') as $img)
                    <div style="display: inline-block; position: relative; margin: 10px;">
                        <img src="{{ $img->getUrl() }}" width="50px" height="50px">
                        <button type="button" class="btn btn-danger btn-sm imgDelete" data-id="{{ $img->id }}" style="position: absolute; top: 0; right: 0;">X</button>
                    </div>
                     @endforeach 
                    <input type="hidden" name="deleted_images" id="deleted_images" value="">   
                    <input type="file" class="form-control" id="banner_image" placeholder="Banner image" name="banner_images[]" multiple>
                    <div class="error">@error('banner_images') {{ $message }} @enderror</div>
                </div>

                <div class="form-group">
                    <label for="thumb_img">Thumbnal Image</label>
                    <img src="{{$product->getFirstMediaUrl('thumb_img')}}" alt="" width="100px" height="100px" style="margin: 10px" id="img">
                    <input type="file" class="form-control" id="thumb_img" placeholder="Product Name" name="thumb_img">
                    <div class="error">@error('thumb_img') {{ $message }} @enderror</div>
                </div>

                <!-- Is Featured Field -->
                <div class="form-group">
                    <label for="is_featured">Is Featured</label>
                    <select class="form-control" id="is_featured" name="is_featured">
                        <option value="0" {{ $product->is_featured == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ $product->is_featured == 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                    <div class="error">@error('is_featured') {{ $message }} @enderror</div>
                </div>

                <!-- SKU Field -->
                <div class="form-group">
                    <label for="sku">SKU</label>
                    <select class="form-control" id="sku" name="sku">
                        <option value="">Select SKU</option>
                        <option value="0" {{ $product->sku == 0 ? 'selected' : '' }}>SKU1</option>
                        <option value="1" {{ $product->sku == 1 ? 'selected' : '' }}>SKU2</option>
                        <!-- Add your SKU options here -->
                    </select>
                    <div class="error">@error('sku') {{ $message }} @enderror</div>
                </div>

                <!-- Quantity Field -->
                <div class="form-group">
                    <label for="qty">Quantity</label>
                    <select class="form-control" id="qty" name="qty">
                        <option value="">Select Quantity</option>
                        <option value="1" {{ $product->qty == 1 ? 'selected' : '' }}>Quantity1</option>
                        <!-- Add your Quantity options here -->
                    </select>
                    <div class="error">@error('qty') {{ $message }} @enderror</div>
                </div>

                <!-- Stock Status Field -->
                <div class="form-group">
                    <label for="stock_status">Stock Status</label>
                    <select class="form-control" id="stock_status" name="stock_status">
                        <option value="1" {{ $product->stock_status == 1? 'selected' : '' }}>In Stock</option>
                        <option value="0" {{ $product->stock_status == 0 ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                    <div class="error">@error('stock_status') {{ $message }} @enderror</div>
                </div>

                <!-- Weight Field -->
                <div class="form-group">
                    <label for="weight">Weight</label>
                    <input type="text" class="form-control" id="weight" placeholder="Weight" name="weight" value="{{ $product->weight }}">
                    <div class="error">@error('weight') {{ $message }} @enderror</div>
                </div>

                <!-- Price Field -->
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" placeholder="Price" name="price" value="{{ $product->price}}">
                    <div class="error">@error('price') {{ $message }} @enderror</div>
                </div>

                <!-- Special Price Field -->
                <div class="form-group">
                    <label for="special_price">Special Price</label>
                    <input type="text" class="form-control" id="special_price" placeholder="Special Price" name="special_price" value="{{ $product->special_price }}">
                    <div class="error">@error('special_price') {{ $message }} @enderror</div>
                </div>

                <!-- Special Price Date Range Fields -->
                <div class="form-group">
                    <label for="special_price_from">Special Price From</label>
                    <input type="date" class="form-control" id="special_price_from" name="special_price_from" value="{{ $product->special_price_from }}">
                    <div class="error">@error('special_price_from') {{ $message }} @enderror</div>
                </div>

                <div class="form-group">
                    <label for="special_price_to">Special Price To</label>
                    <input type="date" class="form-control" id="special_price_to" name="special_price_to" value="{{ $product->special_price_to}}">
                    <div class="error">@error('special_price_to') {{ $message }} @enderror</div>
                </div>

                <!-- Short Description Field -->
                <div class="form-group">
                    <label for="short_description">Short Description</label>
                    <textarea name="short_description" class="form-control" id="short_description" placeholder="Short Description">{{ $product->short_description }}</textarea>
                    <div class="error">@error('short_description') {{ $message }} @enderror</div>
                </div>

                <!-- Description Field -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" id="content" placeholder="Full Description">{{ $product->description }}</textarea>
                    <div class="error">@error('description') {{ $message }} @enderror</div>
                </div>

                <!-- Related Products Field -->
                {{-- <div class="form-group">
                    <label for="related_product">Related Products</label>
                    <input type="text" class="form-control" id="related_product" placeholder="Related Products (Comma separated IDs)" name="related_product" value="{{ $product->related_product}}">
                    <div class="error">@error('related_product') {{ $message }} @enderror</div>
                </div> --}}

                <!-- URL Key Field -->
                <div class="form-group">
                    <label for="url_key">URL Key</label>
                    <input type="text" class="form-control" id="url_key" placeholder="URL Key" name="url_key" value="{{ $product->url_key}}">
                    <div class="error">@error('url_key') {{ $message }} @enderror</div>
                </div>

                <!-- Meta Tag Field -->
                <div class="form-group">
                    <label for="meta_tag">Meta Tag</label>
                    <input type="text" class="form-control" id="meta_tag" placeholder="Meta Tag" name="meta_tag" value="{{ $product->meta_tag }}">
                    <div class="error">@error('meta_tag') {{ $message }} @enderror</div>
                </div>
                <!-- Meta Title Field -->
                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" placeholder="Meta Title" name="meta_title" value="{{ $product->meta_title }}">
                    <div class="error">@error('meta_title') {{ $message }} @enderror</div>
                </div>

                <!-- Meta Description Field -->
                <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <textarea name="meta_description" class="form-control" id="meta_description" placeholder="Meta Description">{{ $product->meta_description }}</textarea>
                    <div class="error">@error('meta_description') {{ $message }} @enderror</div>
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
<script>
$(document).ready(function() {
    $(document).on('click', '.imgDelete', function() {
        imgId = $(this).data('id');
        button = $(this); 

        deletedImages = $('#deleted_images').val();
        $('#deleted_images').val(deletedImages ? deletedImages + ',' + imgId : imgId);

        button.closest('div').remove();
    });
});
</script>
@endsection

