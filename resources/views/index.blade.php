@extends('layout.layout')
@section('content')
<style>
    .product-img img {
        height: 200px;
        /* Set your desired height */
        object-fit: cover;
        /* Ensures the image scales correctly */
        width: 100%;
        /* Makes sure the image fills the container width */
    }

    .card.product-item.border-0.mb-4 {
        width: 100%;
        margin: auto;
        margin-bottom: auto;
    }

    .card-header.product-img.position-relative.overflow-hidden.bg-transparent.border.p-0 {
        position: absolute;
        margin: auto;
    }



    .d-flex.justify-content-around {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
    }

    .cat-item {
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .cat-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    .cat-img {
        border-radius: 50%;
        overflow: hidden;
        background-color: #fff;
    }

    .cat-img img {
        object-fit: cover;
    }

    .cat-item h5 {
        margin-top: 15px;
        font-size: 1.1rem;
        color: #333;
    }
</style>
@if (session('message'))
<div class="alert alert-success">
    {{ session('message') }}
</div>
@endif
<script>
    $(document).ready(function() {
        $('#header-carousel').carousel({
            interval: 5000 // Auto-slide every 5 seconds
        });
    });
</script>

@section('slider')
<div id="header-carousel" class="carousel slide" data-ride="carousel" data-interval="5000">
    <div class="carousel-inner">
        @foreach ($sliders as $key => $slider)
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}" style="height: 410px;">
            <img class="img-fluid" src="{{$slider->getFirstMediaUrl('img')}}" alt="Image">
            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                <div class="p-3" style="max-width: 700px;">
                    <h4 class="text-light text-uppercase font-weight-medium mb-3">{{$slider->title}}</h4>
                    <h3 class="display-4 text-white font-weight-semi-bold mb-4">Fashionable Dress</h3>
                    {{-- <a href="" class="btn btn-light py-2 px-3">Shop Now</a> --}}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#header-carousel" role="button" data-slide="prev">
        <div class="btn btn-dark" style="width: 45px; height: 45px;">
            <span class="carousel-control-prev-icon mb-n2"></span>
        </div>
    </a>
    <a class="carousel-control-next" href="#header-carousel" role="button" data-slide="next">
        <div class="btn btn-dark" style="width: 45px; height: 45px;">
            <span class="carousel-control-next-icon mb-n2"></span>
        </div>
    </a>

</div>
</div>
</nav>
@endsection

<!-- Navbar End -->

<!-- Featured Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
            </div>
        </div>
    </div>
</div>

<!-- Featured End -->

<!-- Categories Start -->
<div class="container-fluid pt-5">
    <div class="row d-flex justify-content-center px-xl-5 pb-3">
        @foreach($categories as $category)
        <div class="col-lg-3 col-md-4 col-sm-6 pb-4">
            <div class="cat-item d-flex flex-column align-items-center text-center border mb-4"
                style="padding: 20px; height: 320px;">
                <p class="text-right">{{ $category->products_count }} Products</p>
                <a href="{{ route('category.products', $category->id) }}"
                    class="cat-img position-relative overflow-hidden mb-3" style="width: 150px; height: 150px;">
                    @if($category->products->isNotEmpty())
                    <img class="img-fluid w-100 h-100"
                        src="{{ $category->products->first()->getFirstMediaUrl('thumb_img') }}"
                        alt="{{ $category->name }}" style="object-fit: cover;">
                    @else
                    <img class="img-fluid w-100 h-100" src="{{ asset('assets/img/default-category.jpg') }}"
                        alt="{{ $category->name }}" style="object-fit: cover;">
                    @endif
                </a>
                <h5 class="font-weight-semi-bold m-0">{{ $category->name }}</h5>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Categories End -->

<!-- Offer Start -->

<div class="col-12 pb-1">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <form action="/search" method="GET" class="search-form">
            <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Search..." aria-label="Search"
                    value="{{ htmlspecialchars($_GET['query'] ?? '')}}">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-search input-group-text bg-transparent text-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
        <div class="dropdown ml-4">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Sort by
            </button>
            <div class="dropdown-menu dropdown-menu-right p-2" aria-labelledby="triggerId" style="min-width: 200px;">
                <select class="form-select" id="sortorderby" name="sortorderby">
                    <option value="-1" {{ $sortorder == -1 ? 'selected' : '' }}>Default</option>
                    <option value="1" {{ $sortorder == 1 ? 'selected' : '' }}>Date, new to old</option>
                    <option value="2" {{ $sortorder == 2 ? 'selected' : '' }}>Date, old to new</option>
                    <option value="3" {{ $sortorder == 3 ? 'selected' : '' }}>Price, low to high</option>
                    <option value="4" {{ $sortorder == 4 ? 'selected' : '' }}>Price, high to low</option>
                </select>
            </div>

            <form action="{{ route('/') }}" id="filterfrm" method="GET">
                <input type="hidden" id="sortorderbyHidden" name="sortorderby" value="{{ $sortorder }}">
            </form>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(function() {
                    $('#sortorderby').on('change', function() {
                        let selectedValue = $(this).val();
                        $('#sortorderbyHidden').val(selectedValue); // Update hidden input value
                        $('#filterfrm').submit(); // Submit the form
                    });
                });
            </script>

        </div>

    </div>
</div>
<!-- Offer End -->

<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Latest Product</span></h2>
    </div>
    <div class="row px-xl-5 pb-3" id="product-list">
        @foreach ($products as $product)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid w-100" src="{{$product->getFirstMediaUrl('thumb_img')}}" alt="">
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3">{{$product->name}}</h6>
                    <div class="d-flex justify-content-center">
                        <h6>
                            @php
                            $finalPrice = getSpecialPrice(
                            $product->price,
                            $product->special_price,
                            $product->special_price_from,
                            $product->special_price_to
                            );
                            @endphp

                            ₹{{ $finalPrice }}</h6>
                        <h6 class="text-muted ml-2">
                            @if ($finalPrice < $product->price)
                                <del class="dark">₹{{ $product->price }}</del>
                                @endif
                        </h6>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="{{ route('detail', $product->url_key) }}" class="btn btn-sm text-dark p-0">
                        <i class="fas fa-eye text-primary mr-1"></i>View Detail
                    </a>

                    @if (auth()->check() && auth()->user()->wishlist && auth()->user()->wishlist->contains('product_id',
                    $product->id))
                    <!-- If the product is in the wishlist, show "Remove from Wishlist" -->
                    <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-heart text-green mr-1"></i>Remove from Wishlist
                        </button>
                    </form>
                    @else
                    <!-- If the product is not in the wishlist or user is not logged in, show "Add to Wishlist" -->
                    <form action="{{ route('wishlist') }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-heart text-primary mr-1"></i>Add to Wishlist
                        </button>
                    </form>
                    @endif

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Products End -->

<!-- Subscribe Start -->
<div class="container-fluid bg-secondary my-5">
    <div class="row justify-content-md-center py-5 px-xl-5">
        <div class="col-md-6 col-12 py-5">
            <div class="text-center mb-2 pb-2">
                <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2">Stay Updated</span></h2>
                <p>Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod duo
                    labore labore.</p>
            </div>
            <form action="">
                <div class="input-group">
                    <input type="text" class="form-control border-white p-4" placeholder="Email Goes Here">
                    <div class="input-group-append">
                        <button class="btn btn-primary px-4">Subscribe</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Subscribe End -->

<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Trendy Products</span></h2>
    </div>
    <div class="row px-xl-5 pb-3" id="product-list">
        @foreach ($productss as $product)
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="card product-item border-0 mb-4">
                <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                    <img class="img-fluid w-100" src="{{$product->getFirstMediaUrl('thumb_img')}}" alt="">
                </div>
                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                    <h6 class="text-truncate mb-3">{{$product->name}}</h6>
                    <div class="d-flex justify-content-center">
                        <h6>
                            @php
                            $finalPrice = getSpecialPrice(
                            $product->price,
                            $product->special_price,
                            $product->special_price_from,
                            $product->special_price_to
                            );
                            @endphp

                            ₹{{ $finalPrice }}</h6>
                        <h6 class="text-muted ml-2">
                            @if ($finalPrice < $product->price)
                                <del class="dark">₹{{ $product->price }}</del>
                                @endif
                        </h6>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between bg-light border">
                    <a href="{{ route('detail', $product->url_key) }}" class="btn btn-sm text-dark p-0">
                        <i class="fas fa-eye text-primary mr-1"></i>View Detail
                    </a>
                    {{-- @php
                    dd($product->id);
                @endphp --}}
                @if (auth()->check() && auth()->user()->wishlist && auth()->user()->wishlist->contains('product_id', $product->id))        
                    <!-- If the product is in the wishlist, show "Remove from Wishlist" -->
                    <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-heart text-green mr-1"></i>Remove from Wishlist
                        </button>
                    </form>
                    @else
                    <!-- If the product is not in the wishlist or user is not logged in, show "Add to Wishlist" -->
                    <form action="{{ route('wishlist') }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button type="submit" class="btn btn-sm text-dark p-0">
                            <i class="fas fa-heart text-primary mr-1"></i>Add to Wishlist
                        </button>
                    </form>
                    @endif

                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- Products End -->

<!-- Vendor Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel vendor-carousel">
                <div class="vendor-item border p-4">
                    <img src="assets/img/vendor-1.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="assets/img/vendor-2.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="assets/img/vendor-3.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="assets/img/vendor-4.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="assets/img/vendor-5.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="assets/img/vendor-6.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="assets/img/vendor-7.jpg" alt="">
                </div>
                <div class="vendor-item border p-4">
                    <img src="assets/img/vendor-8.jpg" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Vendor End -->

@endsection