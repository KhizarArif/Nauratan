<div class="container mt-5">
    <div class="categories_container">
        @foreach ($categories as $category)
            <h1 class="categories_title">{{ $category->name }}</h1>
            <div class="row">
                @foreach ($category->products as $product)
                    <div class="col-md-4 col-lg-3 col-sm-6 col-xs-12 d-flex flex-column justify-content-between">
                        <div class="product_card border border-2">
                            <div class="img_container position-relative">
                                <a href="javascript:void(0)">
                                    @if ($product->productImages->isNotEmpty())
                                        <img src="{{ asset('uploads/product/large/' . $product->productImages[0]->image) }}"
                                            class="product_image shop-item-image" alt="">
                                    @endif
                                </a>
                                <div class="overlay">
                                    <div class="icons">
                                        <a href="{{ route('front.productDetails', $product->slug) }}">
                                            <i class="fa fa-eye" aria-hidden="true" data-toggle="tooltip"
                                                data-placement="top" title="view details"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="product_details d-flex flex-column">
                                <h5 class="product_title">{{ $product->title }}</h5>
                                <div class="product_price_detail">
                                    <span class="discounted_price">Rs. {{ number_format($product->price, 2) }} </span>
                                    <span class="original_price"> Rs. {{ number_format($product->original_price, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @endforeach
    </div>
</div>
