@extends('layout.layout')
@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
    /* General container styles */
    .d-flex {
        display: flex;
        flex-wrap: wrap;
        /* Ensure it wraps when too wide */
        /* align-items: center; */
        margin-bottom: 1rem;
        /* Space at the bottom */
    }

    /* Styling for the form container */
    form {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        /* Add some space between elements */
    }

    /* Attribute label styles */
    .attribute-label {
        font-weight: 500;
        color: #333;
        margin-right: 40px;
        margin-top: 10px;
        margin-left: -25px;
        /* Space after label */
    }

    /* Attribute values container */
    .attribute-values {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 30px;
    }

    /* Attribute value wrapper */
    .attribute-value {
        display: flex;
        align-items: center;
    }

    /* Input styling */
    .custom-control-input {
        margin-right: 5px;
        /* Space between input and label */
        cursor: pointer;
    }

    /* Label styling */
    .custom-control-label {
        color: #555;
        font-size: 0.9rem;
        cursor: pointer;
        vertical-align: middle;
    }

    .custom-control.custom-radio.custom-control-inline {
        width: 100%;
    }

    /* For checked radio buttons */
    .custom-control-input:checked+.custom-control-label {
        color: #007bff;
        /* Highlight color */
        font-weight: bold;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .d-flex {
            flex-direction: column;
            /* Stack items vertically */
            align-items: flex-start;
            /* Align to the left */
        }

        .attribute-values {
            flex-wrap: wrap;
        }
    }

    .dark {
        color: #000;
        opacity: 0.7;
    }


    .product-item {
        height: 100%;
        /* Ensure the card takes full available height */
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        /* Align content properly */
    }

    .product-img {
        height: 300px;
        /* Adjust as needed */
        overflow: hidden;
        /* Hide overflow for images */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-img img {
        max-height: 100%;
        max-width: 70%;
        object-fit: cover;
        /* Ensure images fit within the area */
    }

    .product-body {
        flex-grow: 1;
        /* Allow content to stretch */
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-footer {
        margin-top: auto;
        /* Stick footer to the bottom */
    }


    /* Flex container styling */
    .d-flex.flex-wrap {
        gap: 15px;
        /* Space between cards */
    }

    /* Flex items */
    .flex-item {
        flex: 1 1 calc(25% - 15px);
        /* Adjust for 4 items per row */
        max-width: calc(25% - 15px);
        /* Ensure cards are 25% width */
        display: flex;
        flex-direction: column;
    }

    /* Ensure cards have the same height */
    .product-item {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    /* Adjust card content height */
    .product-img {
        flex-shrink: 0;
        height: 200px;
        /* Adjust this for your image height */
        overflow: hidden;
    }

    .card-body {
        flex-grow: 1;
        /* Ensures body takes up remaining space */
    }

    .card-footer {
        flex-shrink: 0;
    }
</style>

<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{route('/')}}">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Shop Detail</p>
        </div>
    </div>
</div>
@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
<!-- Page Header End -->

<!-- Shop Detail Start -->
<div class="container-fluid py-5">

    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <div id="product-carousel" class="carousel slide" data-ride="carousel" data-interval="5000">
                <div class="carousel-inner border">
                    @php
                    $banner_images = $details->getMedia('banner_images'); // Fetch all media for banner_images
                    @endphp

                    @foreach ($banner_images as $index => $image)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img class="w-100 h-100" src="{{ $image->getUrl() }}" alt="Banner Image {{ $index + 1 }}">
                    </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#product-carousel" role="button" data-slide="prev">
                    <i class="fa fa-2x fa-angle-left text-dark"></i>
                </a>
                <a class="carousel-control-next" href="#product-carousel" role="button" data-slide="next">
                    <i class="fa fa-2x fa-angle-right text-dark"></i>
                </a>
            </div>

        </div>

        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold">{{$details->name}}</h3>
            <div class="d-flex mb-3">
                <div class="text-primary mr-2">
                    <small class="fas fa-star"></small>
                    <small class="fas fa-star"></small>
                    <small class="fas fa-star"></small>
                    <small class="fas fa-star-half-alt"></small>
                    <small class="far fa-star"></small>
                </div>
                <small class="pt-1">(50 Reviews)</small>
            </div>
            <h3 class="font-weight-semi-bold mb-4">
                @php
                $currentDate = \Carbon\Carbon::now(); // Get the current date
                $specialPriceValid = $details->special_price_from <= $currentDate && 
                                     $details->special_price_to >= $currentDate;
            
                $finalPrice = $specialPriceValid ? $details->special_price : $details->price;
            @endphp
            
            <h3 class="font-weight-semi-bold mb-4">
                ₹{{ $finalPrice }}
                @if ($specialPriceValid)
                    <!-- Show original price only if there's a valid special price -->
                    <span class="dark">
                        <del class="dark">₹{{ $details->price }}</del>
                    </span>
                @endif
            </h3>
            <p class="mb-4">{{$details->short_description}}</p>
            <!-- form start -->
            <form action="{{ route('add_to_cart') }}" method="POST">
                @csrf
                <input type="hidden" id="product_id" name="product_id" value="{{ $details->id }}">
                
                <div class="d-flex mb-3">
                    @foreach($details->productattribute->groupBy('attribute_id') as $key => $value)
                        @php
                            $attribute = $value->first()->attribute->name;
                        @endphp
                        <div class="custom-control custom-radio custom-control-inline">
                            <label class="attribute-label">{{ $attribute }}:</label>
                            <div class="attribute-values">
                                @foreach ($value as $item)
                                    <div class="attribute-value">
                                        <input 
                                        type="radio" 
                                        class="custom-control-input" 
                                        id="name{{$item->id}}" 
                                        name="attributes[{{ $attribute }}]" 
                                        value="{{ $item->attributeValue->name}}">
                                        <label class="custom-control-label" for="name{{$item->id}}">
                                            {{ $item->attributeValue->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            
                <div class="d-flex align-items-center mb-4 pt-2">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" 
                               class="form-control bg-secondary text-center" 
                               name="quantity" 
                               value="1">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary px-3">
                        <i class="fa fa-shopping-cart mr-1"></i> Add To Cart
                    </button>
                </div>
            </form>
<!-- form end -->            
            <div class="d-flex pt-2">
                <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                <div class="d-inline-flex">
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="">
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews (0)</a>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <h4 class="mb-3">Product Description</h4>
                    <p>{!!$details->description!!}</p>
                    <p>{!!$details->description!!}</p>
                </div>
                <div class="tab-pane fade" id="tab-pane-2">
                    <h4 class="mb-3">Additional Information</h4>
                    <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt
                        duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur
                        invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet
                        rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam
                        consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam,
                        ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr
                        sanctus eirmod takimata dolor ea invidunt.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                </li>
                                <li class="list-group-item px-0">
                                    Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                </li>
                                <li class="list-group-item px-0">
                                    Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                </li>
                                <li class="list-group-item px-0">
                                    Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                </li>
                                <li class="list-group-item px-0">
                                    Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                </li>
                                <li class="list-group-item px-0">
                                    Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                </li>
                                <li class="list-group-item px-0">
                                    Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-pane-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-4">1 review for "Colorful Stylish Shirt"</h4>
                            <div class="media mb-4">
                                <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                <div class="media-body">
                                    <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                    <div class="text-primary mb-2">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                    <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsum et no
                                        at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h4 class="mb-4">Leave a review</h4>
                            <small>Your email address will not be published. Required fields are marked *</small>
                            <div class="d-flex my-3">
                                <p class="mb-0 mr-2">Your Rating * :</p>
                                <div class="text-primary">
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                            </div>
                            <form>
                                <div class="form-group">
                                    <label for="message">Your Review *</label>
                                    <textarea id="message" cols="30" rows="5" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="name">Your Name *</label>
                                    <input type="text" class="form-control" id="name">
                                </div>
                                <div class="form-group">
                                    <label for="email">Your Email *</label>
                                    <input type="email" class="form-control" id="email">
                                </div>
                                <div class="form-group mb-0">
                                    <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->

<!-- Products Start -->
<div class="container-fluid py-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="d-flex flex-wrap justify-content-around">
                @if($relatedproducts)
                @foreach($relatedproducts as $related_product)
                @php
                $related_p = $related_product->getFirstMediaUrl('thumb_img');
                @endphp
                <div class="card product-item border-0 flex-item">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid w-100" src="{{ $related_p }}" alt="{{ $related_product->name }}">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{ $related_product->name }}</h6>
                        <div class="d-flex justify-content-center">
                            <h6>
                                @php
                                $finalPrice = getSpecialPrice(
                                $related_product->price,
                                $related_product->special_price,
                                $related_product->special_price_from,
                                $related_product->special_price_to
                                );
                                @endphp
                                ₹{{ $finalPrice }}
                            </h6>
                            <h6 class="text-muted ml-2">
                                @if ($finalPrice < $related_product->price)
                                    <span class="dark">
                                        <del class="dark">₹{{ $related_product->price }}</del>
                                    </span>
                                    @endif
                            </h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{ route('detail', $related_product->url_key) }}" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-eye text-primary mr-1"></i>View Detail
                        </a>
                        <a href="#" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart
                        </a>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>

</div>

@endsection