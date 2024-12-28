@extends('admin.layout.layout')
@section('content')
<style>
    .error {
        color: red;
    }
    .attribute-group {
    margin-bottom: 15px; /* Add space between different attributes */
}

.attribute-label {
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.attribute-values {
    display: flex; /* Use flexbox to display checkboxes in a row */
    flex-wrap: wrap; /* Allow wrapping if needed */
    gap: 10px; /* Space between each checkbox and label */
}

.attribute-value {
    display: flex; /* Ensure label and checkbox are aligned in a row */
    align-items: center; /* Center-align checkbox and label vertically */
}

.attribute-value input {
    margin-right: 5px; /* Space between checkbox and label */
}

</style>
<section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-danger">
            <h4 class="card-title">Add Product</h4>
            <form class="forms-sample" action="{{ route('product.store') }}" method="post" enctype="multipart/form-data" id="productForm">
                @csrf
                <div class="form-group">
                    <label for="category_name">Select Categary</label>
                    <select name="category_name[]" id="category_name" class="form-control" multiple>
                        <option value="">Select Categary</option>
                        @foreach ($categories as $item)
                        <option value="{{ $item->id }}" {{ in_array($item->id, old('category_name', [])) ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                    </select>
                </div>

                <!-- Related Products Field -->
                <div class="form-group">
                    <label for="related_product">Related Products</label>
                    <select name="related_product[]" id="related_product" class="form-control" multiple>
                        <option value="">Select Related Product</option>
                        @foreach ($related_products as $item)
                        <option value="{{ $item->id }}" {{ in_array($item->id, old('related_product', [])) ? 'selected' : '' }}>
                            {{ $item->name }}
                        </option>
                    @endforeach
                    </select>
                </div>

                <!-- Name Field -->
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Product Name" name="name" value="{{ old('name') }}">
                    <div class="error">@error('name') {{ $message }} @enderror</div>
                </div>

                <!-- Status Field -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="">Select Status</option>
                        <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Enable</option>
                        <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>Disable</option>
                    </select>
                    <div class="error">@error('status') {{ $message }} @enderror</div>
                </div>
                <div class="form-group">
                    <label for="banner_image">Banner Image</label>
                    <input type="file" class="form-control" id="preview" placeholder="Banner image" name="banner_images[]" multiple onchange="previewImage(event)">
                    <div class="error">@error('banner_image') {{ $message }} @enderror</div>
                </div>
                <div class="form-group">
                    <label for="thumb_img">Thumbnal Image</label>
                    <input type="file" class="form-control" id="thumb_img" placeholder="Product Name" name="thumb_img">
                    <div class="error">@error('thumb_img') {{ $message }} @enderror</div>
                </div>

                <!-- Is Featured Field -->
                <div class="form-group">
                    <label for="is_featured">Is Featured</label>
                    <select class="form-control" id="is_featured" name="is_featured">
                        <option value="0" {{old('is_featured')=='0'?'selected':''}}>No</option>
                        <option value="1" {{old('is_featured')=='1'?'selected':''}}>Yes</option>
                    </select>
                    <div class="error">@error('is_featured') {{ $message }} @enderror</div>
                </div>

                <!-- SKU Field -->
                <div class="form-group">
                    <label for="sku">SKU</label>
                    <select class="form-control" id="sku" name="sku">
                        <option value="">Select SKU</option>
                        <option value="0" {{ old('sku')==0?'selected':''}}>SKU 1</option>
                        <option value="1" {{ old('sku')==1?'selected':''}}>SKU 2</option>
                        <!-- Add your SKU options here -->
                    </select>
                    <div class="error">@error('sku') {{ $message }} @enderror</div>
                </div>

                <!-- Quantity Field -->
                <div class="form-group">
                    <label for="qty">Quantity</label>
                    <select class="form-control" id="qty" name="qty">
                        <option value="">Select Quantity</option>
                        <option value="1" {{ old('qty')==1?'selected':''}}>Quantity 1</option>
                        <option value="2" {{ old('qty')==2?'selected':''}}>Quantity 2</option>
                        <!-- Add your Quantity options here -->
                    </select>
                    <div class="error">@error('qty') {{ $message }} @enderror</div>
                </div>

                <!-- Stock Status Field -->
                <div class="form-group">
                    <label for="stock_status">Stock Status</label>
                    <select class="form-control" id="stock_status" name="stock_status">
                        <option value="1" {{old('stock_status')=='1'?'selected':''}}>In Stock</option>
                        <option value="0" {{old('stock_status')=='0'?'selected':''}}>Out of Stock</option>
                    </select>
                    <div class="error">@error('stock_status') {{ $message }} @enderror</div>
                </div>

                <!-- Weight Field -->
                <div class="form-group">
                    <label for="weight">Weight</label>
                    <input type="text" class="form-control" id="weight" placeholder="Weight" name="weight" value="{{ old('weight') }}">
                    <div class="error">@error('weight') {{ $message }} @enderror</div>
                </div>

                <!-- Price Field -->
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" placeholder="Price" name="price" value="{{ old('price') }}">
                    <div class="error">@error('price') {{ $message }} @enderror</div>
                </div>

                <!-- Special Price Field -->
                <div class="form-group">
                    <label for="special_price">Special Price</label>
                    <input type="text" class="form-control" id="special_price" placeholder="Special Price" name="special_price" value="{{ old('special_price') }}">
                    <div class="error">@error('special_price') {{ $message }} @enderror</div>
                </div>

                <!-- Special Price Date Range Fields -->
                <div class="form-group">
                    <label for="special_price_from">Special Price From</label>
                    <input type="date" class="form-control" id="special_price_from" name="special_price_from" value="{{ old('special_price_from') }}">
                    <div class="error">@error('special_price_from') {{ $message }} @enderror</div>
                </div>

                <div class="form-group">
                    <label for="special_price_to">Special Price To</label>
                    <input type="date" class="form-control" id="special_price_to" name="special_price_to" value="{{ old('special_price_to') }}">
                    <div class="error">@error('special_price_to') {{ $message }} @enderror</div>
                </div>

                <!-- Short Description Field -->
                <div class="form-group">
                    <label for="short_description">Short Description</label>
                    <textarea name="short_description" class="form-control" id="short_description" placeholder="Short Description">{{ old('short_description') }}</textarea>
                    <div class="error">@error('short_description') {{ $message }} @enderror</div>
                </div>

                <!-- Description Field -->
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" id="content" placeholder="Full Description">{{ old('description') }}</textarea>
                    <div class="error">@error('description') {{ $message }} @enderror</div>
                </div>


                {{-- <!-- URL Key Field -->
                <div class="form-group">
                    <label for="url_key">URL Key</label>
                    <input type="text" class="form-control" id="url_key" placeholder="URL Key" name="url_key" value="{{ old('url_key') }}">
                    <div class="error">@error('url_key') {{ $message }} @enderror</div>
                </div> --}}

                <!-- Meta Tag Field -->
                <div class="form-group">
                    <label for="meta_tag">Meta Tag</label>
                    <input type="text" class="form-control" id="meta_tag" placeholder="Meta Tag" name="meta_tag" value="{{ old('meta_tag') }}">
                    <div class="error">@error('meta_tag') {{ $message }} @enderror</div>
                </div>
                {{-- <div class="form-group">
                @foreach ($attributes as $item)
                <input type="hidden" name="attribute[{{$item->id}}][]" id="attribute" value="{{$item->id}}">
                <label>{{ $item->name }}</label>
                <div style="margin-left: 20px;">
                    @foreach ($attributesvalue->where('attribute_id', $item->id) as $item2)
                        <input type="checkbox" id="attribute_value{{ $item2->id }}" name="attributevalues[{{ $item2->id }}][]" value="{{ $item2->id }}">
                        <label for="attribute_value{{ $item2->id }}">{{ $item2->name }}</label>
                    @endforeach
                </div>
            @endforeach
        </div> --}}

        <div class="form-group">
            @foreach ($attributes as $attribute)
                <div class="attribute-group">
                    <label class="attribute-label">{{ $attribute->name }}</label>
                    <div class="attribute-values">
                        @foreach ($attribute->attributevalues as $attributeValue)
                            <div class="attribute-value">
                                <input type="checkbox" name="attr_value[]" 
                                       id="{{ $attributeValue->name }}" 
                                       value="{{ $attributeValue->id }}">
                                <label for="{{ $attributeValue->name }}" style="vertical-align:0;">
                                    {{ $attributeValue->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        
            
              
                <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" placeholder="Meta Title" name="meta_title" value="{{ old('meta_title') }}">
                    <div class="error">@error('meta_title') {{ $message }} @enderror</div>
                </div>

                <!-- Meta Description Field -->
                <div class="form-group">
                    <label for="meta_description">Meta Description</label>
                    <textarea name="meta_description" class="form-control" id="meta_description" placeholder="Meta Description">{{ old('meta_description') }}</textarea>
                    <div class="error">@error('meta_description') {{ $message }} @enderror</div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
        </div>
    </div>
</div>
</section>
<script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>

<script>
    ClassicEditor.create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });
</script>
{{-- <script>
    function previewImage(event) {
        const output = document.getElementById('preview');
        output.src = URL.createObjectURL(event.target.files[0]);
        output.style.display = 'block';
    }
</script> --}}
@endsection

