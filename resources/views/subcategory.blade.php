@extends('layout.layout')
@section('content')
<style>
    .product-img img {
        height: 200px; /* Set your desired height */
        object-fit: cover; /* Ensures the image scales correctly */
        width: 100%; /* Makes sure the image fills the container width */
    }

    .card.product-item.border-0.mb-4 {
    width: 100%;
    margin: auto;
    margin-bottom: auto;
    height: 370px;
}
.card-header.product-img.position-relative.overflow-hidden.bg-transparent.border.p-0 {
  position: absolute;
  margin: auto;
}
.custom-fild{
    margin-bottom: -50px;
}
.dropdown-menu {
    border: 1px solid #ddd; /* Optional border */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow */
}

.form-select {
    width: 100%;
}

</style>
    <div class="container-fluid bg-secondary mb-5 custom-fild">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Our Shop</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="{{route('/')}}">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shop</p>
            </div>
        </div>
    </div>
 
    <div class="container col md-12">
        <div class="row">
            <!-- Shop Sidebar Start -->
            {{-- <div class="col-lg-3 col-md-12">
                <!-- Price Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by price</h5>
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="price-all">
                            <label class="custom-control-label" for="price-all">All Price</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-1">
                            <label class="custom-control-label" for="price-1">$0 - $100</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-2">
                            <label class="custom-control-label" for="price-2">$100 - $200</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-3">
                            <label class="custom-control-label" for="price-3">$200 - $300</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="price-4">
                            <label class="custom-control-label" for="price-4">$300 - $400</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="price-5">
                            <label class="custom-control-label" for="price-5">$400 - $500</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div>
                <!-- Price End -->
                
                {{-- <!-- Color Start -->
                <div class="border-bottom mb-4 pb-4">
                    <h5 class="font-weight-semi-bold mb-4">Filter by color</h5>
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="color-all">
                            <label class="custom-control-label" for="price-all">All Color</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-1">
                            <label class="custom-control-label" for="color-1">Black</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-2">
                            <label class="custom-control-label" for="color-2">White</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-3">
                            <label class="custom-control-label" for="color-3">Red</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-4">
                            <label class="custom-control-label" for="color-4">Blue</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="color-5">
                            <label class="custom-control-label" for="color-5">Green</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div>
                <!-- Color End -->

                <!-- Size Start -->
                <div class="mb-5">
                    <h5 class="font-weight-semi-bold mb-4">Filter by size</h5>
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="size-all">
                            <label class="custom-control-label" for="size-all">All Size</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-1">
                            <label class="custom-control-label" for="size-1">XS</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-2">
                            <label class="custom-control-label" for="size-2">S</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-3">
                            <label class="custom-control-label" for="size-3">M</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-4">
                            <label class="custom-control-label" for="size-4">L</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="size-5">
                            <label class="custom-control-label" for="size-5">XL</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div> --}}
                <!-- Size End -->
            {{-- </div>  --}}
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-md-12">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <form action="/search" method="GET" class="search-form">
                                <div class="input-group">
                                    <input 
                                    type="text" 
                                    name="query" 
                                    class="form-control" 
                                    placeholder="Search..." 
                                    aria-label="Search"
                                    value="{{ htmlspecialchars($_GET['query'] ?? '')}}" >
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-search input-group-text bg-transparent text-primary">
                                            <i class="fas fa-search"></i> 
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div class="dropdown ml-4">
                                <button 
                                    class="btn btn-secondary dropdown-toggle" 
                                    type="button" 
                                    id="triggerId" 
                                    data-bs-toggle="dropdown" 
                                    aria-haspopup="true" 
                                    aria-expanded="false">
                                    Sort by
                                </button>
                                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
                                <div class="dropdown-menu dropdown-menu-right p-2" aria-labelledby="triggerId" style="min-width: 200px;">
                                    <select class="form-select" id="sortorderby" name="sortorderby">
                                        <option value="">Date, new to old</option>
                                        <option value="">Date, old to new</option>
                                        <option value="">Price, low to high</option>
                                        <option value="">Price, high to low</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    @foreach ($products as $product)
                    <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid w-100" src="{{$product->getFirstMediaUrl('thumb_img')}}" alt="">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3">{{$product->name}}</h6>
                                <div class="d-flex justify-content-center">
                                    {{-- <h6>₹{{$product->special_price}}</h6><h6 class="text-muted ml-2"><del>₹{{$product->price}}</del></h6> --}}
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
                                        @if ($finalPrice < $product->price) <!-- Show original price only if there's a discount -->
                                            <span class="dark"><del class="dark">₹{{ $product->price }}</del></span></p>
                                        @endif
                                    </h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="{{route('detail',$product->url_key)}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
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


                    {{-- <div class="col-12 pb-1">
                        <nav aria-label="Page navigation">
                          <ul class="pagination justify-content-center mb-3">
                            <li class="page-item disabled">
                              <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                              </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                              <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                              </a>
                            </li>
                          </ul>
                        </nav>
                    </div> --}}
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
@endsection