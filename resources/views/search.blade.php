@extends('layout.layout')
@section('content')
<style>
      .product-img img {
        height: 200px; 
        object-fit: cover; 
        width: 100%; 
    }

.card-header.product-img.position-relative.overflow-hidden.bg-transparent.border.p-0 {
  position: absolute;
  margin: auto;
}

@media (min-width: 992px) {
  .col-lg-12 {
    flex: 0 0 100%;
    max-width: 100%;
    margin-top: 20px;
  }
} 

    .card.product-item {
        display: flex;
        flex-direction: column; 
        justify-content: space-between; 
        height: 100%; 
    }

    .card-body {
        flex-grow: 1; 
    }



    .card-footer {
        background-color: #f8f9fa; 
    }

    @media (min-width: 992px) {
        .col-lg-12 {
            flex: 0 0 100%;
            max-width: 100%;
            margin-top: 20px;
        }
    }


</style>

<div class="container-fluid mb-5">
    <div class="row border-top px-xl-5">
        <div class="col-lg-12">
            <div class="custom-product">
                <div class="row px-xl-5 pb-3">
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
                                            <!-- Show original price only if there's a discount -->
                                            <span class="dark"><del class="dark">₹{{ $product->price }}</del></span></p>
                                            @endif
                                    </h6>                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="{{route('detail',$product->url_key)}}" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-heart text-primary mr-1"></i>Add To Wishlist</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
        </div>
    </div>
</div>
@endsection