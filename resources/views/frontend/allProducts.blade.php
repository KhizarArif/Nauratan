@extends('frontend.layouts.app')

@section('content')

    <div class="container m-5">
        <div class="row">
            @if ($products != null)
                @foreach ($products as $product)
                    <div class="col-md-3 col-sm-6 col-xs-12 filter-item all new d-flex flex-column justify-content-between">
                        <div class="card border border-2 all_product_container">
                            <div class="img-container position-relative">
                                <a href="javascript:void(0)">
                                    <img src="{{ asset('uploads/product/large/' . $product->productImages->first()->image) }}"
                                        class="card-img-top shop-item-image" alt="{{ $product->title }}">
                                </a>
                                <div class="overlay">
                                    <div class="icons">
                                        <a href="javascript:void(0)"  onclick="addToCart('{{ $product->id }}', '{{ $product->productImages->first()->id }}')">
                                            <i class="fa fa-shopping-cart" aria-hidden="true" data-toggle="tooltip"
                                                data-placement="top" title="Add To Cart"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="card-title text-center p-0">{{ $product->title }}</p>
                                <p
                                    class="card-text shop-item-price w-100 d-flex justify-content-evenly align-items-center gap-2">
                                    <span class="discounted-price">Rs. {{ $product->price }} </span>
                                    <span class="original-price">Rs. {{ $product->original_price }} </span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

@endsection
