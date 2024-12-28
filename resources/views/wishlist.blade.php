@extends('layout.layout')
@section('content')
<style>
    .hh:hover{
        color: black;
        background-color: blue;
    }
    .custom-margin{
        padding: 18px;
    }
</style>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 200px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Wishlist</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="{{ route('/') }}">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Wishlist</p>
        </div>
    </div>
</div>
@if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif
<!-- Page Header End -->

<!-- Wishlist Start -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered text-center mb-0">
                <thead class="bg-secondary text-dark">
                    <tr>
                        <th>Products</th>
                        <th>Price</th>
                        {{-- <th>Quantity</th> --}}
                        {{-- <th>Total</th> --}}
                        <th>Remove</th>
                        <th>Add to Cart</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @if ($wishlist->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">
                                <h5>Your Wishlist is empty</h5>
                            </td>
                        </tr>
                    @else
                        @foreach ($wishlist as $item)
                        <tr>
                            <td class="align-middle">
                                <img src="{{ $item->product->getFirstMediaUrl('thumb_img') }}" alt="" style="width: 50px;">
                                {{ $item->product->name }}
                            </td>
                            <td class="align-middle">₹{{ $item->product->price }}</td>
                            <td class="align-middle">
                                <form method="POST" action="{{ route('wishlist.remove', $item->id) }}">
                                    @csrf
                                    <button class="btn btn-sm btn-primary"><i class="fa fa-times"></i></button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" class="custom-margin" action="{{ route('addCart', $item->product->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success hh">Add to Cart</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
                
            </table>
        </div>
    </div>
</div>
<!-- Wishlist End -->
@endsection
