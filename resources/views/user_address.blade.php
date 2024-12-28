@extends('layout.layout')
@section('content')
<div class="container">
    <h1>Your Addresses</h1>

        <!-- Display addresses in a table -->
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($addresss as $address)
                <tr>
                    <td>{{ $address->name }}</td>
                    <td>{{ $address->email }}</td>
                    <td>{{ $address->phone }}</td>
                    <td>{{ $address->address }}</td>
                    <td>{{ ucfirst($address->address_type) }}</td>
                    <td>
                        <button class="btn btn-warning edit-address" 
                                data-type="{{ $address->address_type }}" 
                                data-name="{{ $address->name }}" 
                                data-email="{{ $address->email }}" 
                                data-phone="{{ $address->phone }}" 
                                data-address1="{{ $address->address1 }}" 
                                data-address2="{{ $address->address2 }}" 
                                data-city="{{ $address->city }}" 
                                data-state="{{ $address->state }}" 
                                data-country="{{ $address->country }}" 
                                data-pincode="{{ $address->pincode }}">
                            Edit
                        </button>
                        <form action="{{ route('delete_address', $address->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
   
    <button id="addAddressBtn" class="btn btn-primary">Add New Address</button>


    <!-- New Address Form -->
    <div id="newAddressForm" style="display: none; margin-top: 20px;">
        <h3>New Address</h3>
       
        <form action="{{route('add_address')}}" method="POST">
            @csrf     
            <input type="hidden" name="order_id" id="order_id" value="{{ $address->order_id}}">
            <div class="row px-xl-5">
                <div class="col-lg-8">
                    <div class="mb-4">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Name</label>
                                <input class="form-control" name="name" type="text" placeholder="Name">
                               @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" name="email" type="text" placeholder="Email">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" name="phone" type="text" placeholder="000-0000-000">
                                @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 1</label>
                                <input class="form-control" name="address" type="text" placeholder="Address">
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 2</label>
                                <input class="form-control" name="address_2" type="text" placeholder="Address 2">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" type="text" name="city" id="city" placeholder="City">
                                @error('city')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input class="form-control" name="state" type="text" placeholder="State">
                                @error('state')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <input class="form-control" name="country" type="text" placeholder="Country">
                                @error('country')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address type</label><br>
                                <label for="billing">Billing</label>
                                <input value="billing" name="address_type" type="radio" id="billing"><br>
                                <label for="shipping">Shipping</label>
                                <input value="shipping" name="address_type" type="radio" id="shipping">
                                @error('address_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Pin Code</label>
                                <input class="form-control" name="pincode" type="text" placeholder="Pincode">
                                @error('pincode')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" id="cancel">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
       
    </div>

    <!-- Edit Forms -->
    <div id="billingForm" style="display: none; margin-top: 20px;">
        <h3>Billing Address</h3>
        <form action="{{route('order_addressupdate',$address->id)}}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="address_type" value="billing">
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" name="name" id="billing_name" type="text">
                @error('name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" name="email" id="billing_email" type="text">
                @error('email')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input class="form-control" name="phone" id="billing_phone" type="text">
                @error('phone')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Address Line 1</label>
                <input class="form-control" name="address1" id="billing_address1" type="text">
                @error('address1')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Address Line 2</label>
                <input class="form-control" name="address2" id="billing_address2" type="text">
            </div>
            <div class="form-group">
                <label>City</label>
                <input class="form-control" name="city" id="billing_city" type="text">
                @error('city')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>State</label>
                <input class="form-control" name="state" id="billing_state" type="text">
                @error('state')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Country</label>
                <input class="form-control" name="country" id="billing_country" type="text">
                @error('country')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Pin Code</label>
                <input class="form-control" name="pincode" id="billing_pincode" type="text">
                @error('pincode')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="reset" class="btn btn-secondary cancel">Cancel</button>
        </form>
    </div>

    <div id="shippingForm" style="display: none; margin-top: 20px;">
        <h3>Shipping Address</h3>
        <form action="{{route('order_addressupdate',$address->id)}}" method="POST"> 
            @csrf
            @method('PUT')
            <input type="hidden" name="address_type" value="shipping">
            <div class="form-group">
                <label>Name</label>
                <input class="form-control" name="name" id="shipping_name" type="text">
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" name="email" id="shipping_email" type="text">
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input class="form-control" name="phone" id="shipping_phone" type="text">
                @error('phone')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Address Line 1</label>
                <input class="form-control" name="address1" id="shipping_address1" type="text">
                @error('address1')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Address Line 2</label>
                <input class="form-control" name="address2" id="shipping_address2" type="text">
            </div>
            <div class="form-group">
                <label>City</label>
                <input class="form-control" name="city" id="shipping_city" type="text">
                @error('city')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>State</label>
                <input class="form-control" name="state" id="shipping_state" type="text">
                @error('state')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Country</label>
                <input class="form-control" name="country" id="shipping_country" type="text">
                @error('country')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label>Pin Code</label>
                <input class="form-control" name="pincode" id="shipping_pincode" type="text">
                @error('pincode')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="reset" class="btn btn-secondary cancel">Cancel</button>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Handle Edit button click
    $('.edit-address').click(function() {
        const type = $(this).data('type');
        const formId = type === 'billing' ? '#billingForm' : '#shippingForm';

        // Fill in form values
        $(`${formId} input[name="name"]`).val($(this).data('name'));
        $(`${formId} input[name="email"]`).val($(this).data('email'));
        $(`${formId} input[name="phone"]`).val($(this).data('phone'));
        $(`${formId} input[name="address1"]`).val($(this).data('address1'));
        $(`${formId} input[name="address2"]`).val($(this).data('address2'));
        $(`${formId} input[name="city"]`).val($(this).data('city'));
        $(`${formId} input[name="state"]`).val($(this).data('state'));
        $(`${formId} input[name="country"]`).val($(this).data('country'));
        $(`${formId} input[name="pincode"]`).val($(this).data('pincode'));

        // Show the correct form
        $('#billingForm, #shippingForm').hide();
        $(formId).show();
    });

    // Handle Cancel button click
    $('.cancel').click(function() {
        $('#billingForm, #shippingForm').hide();
    });



    // Show New Address Form
    $('#addAddressBtn').click(function() {
        $('#newAddressForm').show(); 
    });

    // Hide New Address Form
    $('#cancel').click(function() {
        $('#newAddressForm').hide();
    });
});
</script>
@endsection
