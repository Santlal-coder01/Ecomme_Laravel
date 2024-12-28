@extends('layout.layout')
@section('content')

<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Checkout</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Checkout</p>
        </div>
    </div>
</div>
<style>
    .is-invalid {
        border-color: #dc3545;
    }
</style>
<div class="container-fluid pt-5">
    <form action="{{route('orders')}}" method="POST">
        @csrf
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4">Billing Address</h4>

                    <!-- Dropdown for existing billing addresses -->
                    <div class="form-group">
                        <label for="existing_billing_address">Select Existing Billing Address</label>
                        <select id="existing_billing_address" class="form-control">
                            <option value="">Use New Billing Address</option>
                            @foreach ($billingAddresses as $address)
                            <option value="{{ $address->id }}" data-name="{{ $address->name }}"
                                data-email="{{ $address->email }}" data-phone="{{ $address->phone }}"
                                data-address="{{ $address->address }}" data-address_2="{{ $address->address_2 }}"
                                data-city="{{ $address->city }}" data-state="{{ $address->state }}"
                                data-country="{{ $address->country }}" data-pincode="{{ $address->pincode }}">
                                {{ $address->name }} {{ $address->address1 }}, {{ $address->city }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Billing Form -->
                    <div id="billing-form">
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label>Name</label>
                                <input class="form-control" name="name" type="text" placeholder="Name">
                                @error('name')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" name="email" type="text" placeholder="Email">
                                @error('email')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" name="phone" type="text" placeholder="000-0000-000">
                                @error('phone')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 1</label>
                                <input class="form-control" name="address" type="text" placeholder="Address">
                                @error('address')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Address Line 2</label>
                                <input class="form-control" name="address_2" type="text" placeholder="Address 2">
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" name="city" type="text" placeholder="City">
                                @error('city')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input class="form-control" name="state" type="text" placeholder="State">
                                @error('state')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <input class="form-control" name="country" type="text" placeholder="Country">
                                @error('country')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Pin Code</label>
                                <input class="form-control" name="pincode" type="text" placeholder="Pincode">
                                @error('pincode')
                                <small class="form-text text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
               
                    <div class="card border-secondary mb-5">
                        <div class="card-header bg-secondary border-0">
                            <h4 class="font-weight-semi-bold m-0">Shipping Method</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" value="standerd"
                                        name="shipping_method" id="standard" checked>
                                    <label class="custom-control-label" for="standard">Standard Shipping - Free</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" value="express_delivery"
                                        name="shipping_method" id="express">
                                    <label class="custom-control-label" for="express">Express Shipping - ₹50</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" value="same_day_delivery"
                                        name="shipping_method" id="same_day">
                                    <label class="custom-control-label" for="same_day">Same Day Delivery - ₹100</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer border-secondary bg-transparent">
                            <p class="font-weight-medium mb-0">Choose your preferred shipping method.</p>
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="shipto" 
                            {{ old('shipping_name') || old('shipping_email') || $errors->has('shipping_name') || $errors->has('shipping_email') ? 'checked' : '' }}>
                     <label class="custom-control-label" for="shipto" data-toggle="collapse"
                            data-target="#shipping-address">Ship to different address</label>
                        </div>
                    </div>
                </div>

                <div class="collapse mb-4 {{ old('shipping_name') || old('shipping_email') || $errors->has('shipping_name') || $errors->has('shipping_email') ? 'show' : '' }}" id="shipping-address">                <h4 class="font-weight-semi-bold mb-4">Shipping Address</h4>
                <div class="mb-4">
                    <label for="old_addresses">Select Previous Address</label>
                    <select id="old_addresses" class="form-control">
                        <option value="">-- Select an Address --</option>
                        @foreach($shippingAddresses as $address)
                        <option value="{{ json_encode($address) }}">
                            {{ $address->name }}, {{ $address->city }}, {{ $address->state }}, {{ $address->country }}
                        </option>
                        @endforeach
                    </select>
                </div>   
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">Name</label>
                        <input class="form-control" id="name2" name="shipping_name" type="text" placeholder="Name">
                        @error('shipping_name')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>E-mail</label>
                        <input class="form-control" name="shipping_email" type="text" placeholder="Email">
                        @error('shipping_email')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Mobile No</label>
                        <input class="form-control" name="shipping_phone" type="text" placeholder="000-0000-000">
                        @error('shipping_phone')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 1</label>
                        <input class="form-control" name="shipping_address_1" type="text" placeholder="Address">
                        @error('shipping_address_1')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Address Line 2</label>
                        <input class="form-control" name="shipping_address_2" type="text" placeholder="Address 2">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Country</label>
                        <input type="text" class="form-control" name="shipping_country" placeholder="Country">
                        @error('shipping_country')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>City</label>
                        <input class="form-control" name="shipping_city" type="text" placeholder="City">
                        @error('shipping_city')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>State</label>
                        <input class="form-control" name="shipping_state" type="text" placeholder="State">
                        @error('shipping_state')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Pin Code</label>
                        <input class="form-control" name="shipping_pincode" type="text" placeholder="Pincode">
                        @error('shipping_pincode')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if($cartItem)
                {{-- Product Summary Section --}}
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Product Summary</h4>
                    </div>
                    <div class="card-body">
                        @foreach ($cartItem as $item)
                        @if ($item && $item->product)
                            @php
                                // Determine the price to use for the product
                                $price = $item->product->special_price && now()->between($item->product->special_price_from, $item->product->special_price_to) 
                                        ? $item->product->special_price 
                                        : $item->product->price;
        
                                $rowTotal = $price * $item->qty;
                            @endphp
                            <div class="d-flex align-items-center mb-3">
                                <div class="product-image" style="width: 60px; height: 60px; margin-right: 15px;">
                                    <img src="{{ $item->product->getFirstMediaUrl('thumb_img') }}" alt="{{ $item->product->name }}" class="img-fluid rounded">
                                </div>
                                <div class="product-details">
                                    <h6 class="font-weight-medium">{{ $item->product->name }}</h6>
                                    <small>₹{{ $price }} x {{ $item->qty }}</small>
                                </div>
                                <div class="ml-auto">
                                    <h6>₹{{ $rowTotal }}</h6>
                                </div>
                            </div>
                            <hr>
                        @else
                            <div class="alert alert-warning">Some items in your cart could not be loaded. Please check your cart.</div>
                        @endif
                        @endforeach
                    </div>
                </div>
        
                {{-- Order Total Card --}}
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        @php
                            $subtotal = $cartItem->reduce(function ($carry, $item) {
                                $price = $item->product->special_price && now()->between($item->product->special_price_from, $item->product->special_price_to) 
                                        ? $item->product->special_price 
                                        : $item->product->price;
                                return $carry + ($price * $item->qty);
                            }, 0);
                        @endphp
        
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium">₹{{ $subtotal }}</h6>
                            <input type="hidden" name="subtotal" id="subtotal" value="{{ $subtotal }}">
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping Cost</h6>
                            <h6 class="font-weight-medium">₹<span id="shipping_cost_display">0</span></h6>
                            <input type="hidden" id="shipping_cost" name="shipping_cost" value="0">
                        </div>
                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold">₹<span id="total_display">{{ $subtotal }}</span></h5>
                        </div>
                        <input type="hidden" name="total" value="{{ $subtotal }}">
                    </div>
                </div>
            @endif
        
            {{-- Payment Section --}}
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Payment</h4>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" value="Paytm" name="payment" id="Paytm" checked>
                            <label class="custom-control-label" for="Paytm">Paytm</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" value="paypal" name="payment" id="paypal">
                            <label class="custom-control-label" for="paypal">Paypal</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" value="direct check" name="payment" id="directcheck">
                            <label class="custom-control-label" for="directcheck">Direct Check</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" value="bank transfer" name="payment" id="banktransfer">
                            <label class="custom-control-label" for="banktransfer">Bank Transfer</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <button type="submit" class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Place Order</button>
                </div>
            </div>
        </div>
        
</form>
</div>
<!-- Checkout End -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha384-o/2OHZKSKZpihsCkGkQ1E8JJPjxCZry2S70OZh3YYCGOGCI8AWUOqG37C7yD6Btm" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const shipToCheckbox = document.getElementById('shipto');
    const shippingAddressSection = document.getElementById('shipping-address');
    const billingFields = [
        'name', 'email', 'phone', 'address', 'address_2', 
        'city', 'state', 'country', 'pincode'
    ];

    function copyBillingToShipping() {
        billingFields.forEach(field => {
            const billingInput = document.getElementsByName(field)[0];
            const shippingInput = document.getElementsByName(`shipping_${field}`)[0];
            if (billingInput && shippingInput) {
                shippingInput.value = billingInput.value;
            }
        });
    }

  
    function toggleShippingAddress() {
        if (shipToCheckbox.checked) {
            shippingAddressSection.classList.remove('collapse'); 
        } else {
            shippingAddressSection.classList.add('collapse');
            copyBillingToShipping(); 
        }
    }

    if (shipToCheckbox.checked) {
        shippingAddressSection.classList.remove('collapse'); 
    } else {
        shippingAddressSection.classList.add('collapse');
        copyBillingToShipping();
    }

  
    shipToCheckbox.addEventListener('change', toggleShippingAddress);

    const hasErrors = Array.from(document.querySelectorAll('.form-text.text-danger')).length > 0;
    if (hasErrors && shipToCheckbox.checked) {
        shippingAddressSection.classList.remove('collapse'); 
    }
});

</script>



<!--same address -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const shipToCheckbox = document.getElementById('shipto');
        const shippingForm = document.getElementById('shipping-address');
        const billingSelect = document.getElementById('existing_billing_address');
        const shippingSelect = document.getElementById('old_addresses');

        // Billing and shipping fields mapping
        const fieldsMapping = {
            name: 'shipping_name',
            email: 'shipping_email',
            phone: 'shipping_phone',
            address: 'shipping_address_1',
            address_2: 'shipping_address_2',
            city: 'shipping_city',
            state: 'shipping_state',
            country: 'shipping_country',
            pincode: 'shipping_pincode'
        };

        function copyBillingToShipping() {
            for (const [billingField, shippingField] of Object.entries(fieldsMapping)) {
                const billingValue = document.querySelector(`[name="${billingField}"]`).value;
                const shippingInput = document.querySelector(`[name="${shippingField}"]`);
                if (shippingInput) shippingInput.value = billingValue;
            }
        }

        function toggleShippingForm() {
            if (shipToCheckbox.checked) {
                shippingForm.classList.add('show');
            } else {
                shippingForm.classList.remove('show');
                copyBillingToShipping();
            }
        }

        shipToCheckbox.addEventListener('change', toggleShippingForm);

        billingSelect.addEventListener('change', function () {
            const selectedOption = billingSelect.options[billingSelect.selectedIndex];
            for (const [billingField, dataAttr] of Object.entries(fieldsMapping)) {
                const fieldValue = selectedOption.getAttribute(`data-${billingField}`);
                const billingInput = document.querySelector(`[name="${billingField}"]`);
                if (billingInput) billingInput.value = fieldValue || '';
            }
            if (!shipToCheckbox.checked) copyBillingToShipping();
        });

        shippingSelect.addEventListener('change', function () {
            const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
            if (selectedOption.value) {
                const address = JSON.parse(selectedOption.value);
                for (const [key, value] of Object.entries(address)) {
                    const shippingInput = document.querySelector(`[name="shipping_${key}"]`);
                    if (shippingInput) shippingInput.value = value || '';
                }
            }
        });

        toggleShippingForm();
    });
</script>


<!-- same address end -->


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shippingMethods = document.querySelectorAll('[name="shipping_method"]');
        const shippingCostField = document.getElementById('shipping_cost');
        const shippingCostDisplay = document.getElementById('shipping_cost_display');
        const subtotalField = document.getElementById('subtotal');
        const totalDisplay = document.getElementById('total_display');
        const totalField = document.querySelector('[name="total"]');
        function updateTotal() {
            const subtotal = parseFloat(subtotalField.value || 0);
            const shippingCost = parseFloat(shippingCostField.value || 0);
            const total = subtotal + shippingCost;
            totalDisplay.textContent = total.toFixed(2);
            totalField.value = total.toFixed(2);
        }
        shippingMethods.forEach(method => {
            method.addEventListener('change', function() {
                let shippingCost = 0;
                if (this.value === 'standerd') {
                    shippingCost = 0;
                } else if (this.value === 'express_delivery') {
                    shippingCost = 50;
                } else if (this.value === 'same_day_delivery') {
                    shippingCost = 100;
                }
                shippingCostField.value = shippingCost;
                shippingCostDisplay.textContent = shippingCost.toFixed(2);
                updateTotal();
            });
        });
        const selectedMethod = document.querySelector('[name="shipping_method"]:checked');
        if (selectedMethod) {
            selectedMethod.dispatchEvent(new Event('change'));
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const billingDropdown = document.getElementById('existing_billing_address');
        const billingForm = document.getElementById('billing-form');
        const billingFields = ['name', 'email', 'phone', 'address', 'address_2', 'city', 'state', 'country',
            'pincode'
        ];
        billingDropdown.addEventListener('change', function() {
            if (this.value) {
                billingForm.style.display = 'none';
                const selectedOption = this.options[this.selectedIndex];
                billingFields.forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.value = selectedOption.getAttribute(`data-${field}`);
                    }
                });
            } else {
                billingForm.style.display = 'block';
                billingFields.forEach(field => {
                    const input = document.querySelector(`[name="${field}"]`);
                    if (input) {
                        input.value = '';
                    }
                });
            }
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
    const oldAddressesDropdown = document.getElementById('old_addresses');
    const shippingFields = {
        name: document.querySelector('[name="shipping_name"]'),
        email: document.querySelector('[name="shipping_email"]'),
        phone: document.querySelector('[name="shipping_phone"]'),
        address_1: document.querySelector('[name="shipping_address_1"]'),
        address_2: document.querySelector('[name="shipping_address_2"]'),
        city: document.querySelector('[name="shipping_city"]'),
        state: document.querySelector('[name="shipping_state"]'),
        country: document.querySelector('[name="shipping_country"]'),
        pincode: document.querySelector('[name="shipping_pincode"]'),
    };

    oldAddressesDropdown.addEventListener('change', function () {
        const selectedValue = this.value;

        if (selectedValue) {
            const selectedAddress = JSON.parse(selectedValue);

            shippingFields.name.value = selectedAddress.name || '';
            shippingFields.email.value = selectedAddress.email || '';
            shippingFields.phone.value = selectedAddress.phone || '';
            shippingFields.address_1.value = selectedAddress.address || '';
            shippingFields.address_2.value = selectedAddress.address_2 || '';
            shippingFields.city.value = selectedAddress.city || '';
            shippingFields.state.value = selectedAddress.state || '';
            shippingFields.country.value = selectedAddress.country || '';
            shippingFields.pincode.value = selectedAddress.pincode || '';
        } else {
            for (const key in shippingFields) {
                if (shippingFields[key]) {
                    shippingFields[key].value = '';
                }
            }
        }
    });
});

</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const shipToCheckbox = document.getElementById('shipto');
        const shippingForm = document.getElementById('shipping-address');
        const billingFields = document.querySelectorAll('#billing-form input');
        const shippingFields = document.querySelectorAll('#shipping-address input');

        function syncBillingToShipping() {
            billingFields.forEach((field) => {
                const shippingField = document.querySelector(
                    `#shipping-address input[name=shipping_${field.name}]`
                );
                if (shippingField) shippingField.value = field.value;
            });
        }

        shipToCheckbox.addEventListener('change', () => {
            if (shipToCheckbox.checked) {
                shippingForm.classList.add('show');
            } else {
                shippingForm.classList.remove('show');
                syncBillingToShipping(); 
            }
        });

        if (shipToCheckbox.checked) {
            shippingForm.classList.add('show');
        }
    });
</script>


@endsection