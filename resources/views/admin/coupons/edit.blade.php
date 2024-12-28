@extends('admin.layout.layout')
@section('content')
<section class="content">
    <div class="row">
      <div class="col-md-6">
        <div class="box box-danger">
            <h4 class="card-title">Edit Coupon</h4>
            
            <!-- Edit form, using PUT method to update the existing coupon -->
            <form action="{{ route('coupon.update', $coupon->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Title Field -->
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{ old('title', $coupon->title) }}" required>
                </div>
                
                <!-- Coupon Code Field -->
                <div class="form-group">
                    <label for="coupon_code">Coupon Code</label>
                    <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="Enter Coupon Code" value="{{ old('coupon_code', $coupon->coupon_code) }}" required>
                </div>
                
                <!-- Status Field -->
                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="1" {{ old('status', $coupon->status) == '1' ? 'selected' : '' }}>Active</option>
                        <option value="2" {{ old('status', $coupon->status) == '2' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                
                <!-- Valid From Field -->
                <div class="form-group">
                    <label for="valid_from">Valid From</label>
                    <input type="date" class="form-control" id="valid_from" name="valid_from" value="{{ old('valid_from', $coupon->valid_from) }}" required>
                </div>
                
                <!-- Valid To Field -->
                <div class="form-group">
                    <label for="valid_to">Valid To</label>
                    <input type="date" class="form-control" id="valid_to" name="valid_to" value="{{ old('valid_to', $coupon->valid_to) }}" required>
                </div>
                
                <!-- Discount Amount Field -->
                <div class="form-group">
                    <label for="discount_amount">Discount Amount</label>
                    <input type="number" class="form-control" id="discount_amount" name="discount_amount" placeholder="Enter Discount Amount" value="{{ old('discount_amount', $coupon->discount_amount) }}" required min="0">
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Update Coupon</button>
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
@endsection
