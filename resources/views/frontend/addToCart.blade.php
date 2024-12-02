@extends('frontend.layouts.app')

@section('content')


    <section class="container my-4 mt-5">

        @if ($products[0] != null)

            <form class="row addToCartContainer" id="addToCartForm">
                @csrf
                <!-- Product Image Section -->
                @if ($products[0]->productImages->count() > 0)
                    <div class="col-md-6 " style="overflow: auto">
                        <div class="add_cart_product_images mb-4 ">
                            <div class="thumbnail  mt-0">
                                @if ($products[0]->productImages->count() > 1)
                                    @foreach ($products[0]->productImages as $productImage)
                                        <img src="{{ asset('uploads/product/small/' . $productImage->image) }}"
                                            alt="Thumbnail " title="{{ $productImage->image }}" class="thumbnail_image"
                                            onclick="swapImage('{{ asset('uploads/product/large/' . $productImage->image) }}')">
                                    @endforeach
                                @endif
                            </div>
                            <img src="{{ asset('uploads/product/large/' . $productImage->image) }}" id="mainImage"
                                alt="Main Product Image" name="product_image" class="add_to_cart_image mb-4"
                                title="{{ $productImage->image }}">
                        </div>
                    </div>
                @endif
                <input type="hidden" id="selectedImageId" name="product_image_id"
                    value="{{ $products[0]->productImages[0]->id }}">

                <!-- Product Details Section -->
                <div class="col-md-6">
                    <div class="product_details">
                        <div class="d-flex flex-column gap-4 justify-content-between">
                            <h3 name="title" value="{{ $products[0]->title }}"> {{ $products[0]->title }} </h3>
                            <input type="hidden" name="$products[0]->title" value="{{ $products[0]->title }}">
                            <input type="hidden" name="product_id" value="{{ $products[0]->id }}">
                            <div class="d-flex">
                                <h5 class="price" name="price"> Rs. {{ number_format($products[0]->price, 2) }} </h5>
                                <h6 class="original_price" name="original_price">Rs.
                                    {{ number_format($products[0]->original_price, 2) }}
                                </h6>
                            </div>
                        </div>

                        <div class="row d-flex ">
                            {{-- <div class="col-md-4 " style="height: 70%;">
                                <div class="input-group quantity quantity_div border border-dark rounded">
                                    <div class="input_group_btn">
                                        <button class="btn btn-lg btn-minus sub rounded">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="quantity_value" id="quantity-input" name="quantity"
                                        value="1">

                                    <div class="input_group_btn">
                                        <button class="btn btn-lg btn-plus add rounded">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="loader" style="display: none;"></div><!-- Loader here -->
                                </div>
                            </div> --}}
                            <div class="col-md-3 p-0">
                                <p class="mb-0">Quantity</p>
                                <div class="input-group quantity border border-dark rounded">

                                    <button class="btn btn-outline-dark border border-none  btn-bold" type="button"
                                        id="decrement_btn">-</button>

                                    <input type="text" class="text-center border border-none" id="quantity_input"
                                        name="quantity" value="1" style="width: 2rem;">

                                    <button class="btn btn-outline-dark border border-none  btn-bold " type="button"
                                        id="increment_btn">+</button>

                                </div>

                            </div>

                            <div class="col-md-8 d-flex align-items-end">
                                <a class="addToCartButton"
                                    href="javascript:void(0)"onclick="addToCart('{{ $products[0]->id }}', '{{ $products[0]->title }}', '{{ $products[0]->price }}')">
                                    <div >
                                        Add to cart
                                    </div>

                                </a>
                            </div>
                        </div>
                        <div class="addToCartBedge">
                            <img src="{{ asset('frontend_assets/img/badges.jpg') }}" alt=""
                                class="addToCartBedgeImg">
                        </div>

                    </div>
                </div>
            </form>

            <div class="description_container">
                <div class="tablinks active" onclick="openCity(event, 'descriptionTab')"> Product Description </div>
                <div class="tablinks" onclick="openCity(event, 'shippingReturnTab')"> Shipping & Return </div>
            </div>
            <div id="descriptionTab" class="tabcontent" style="display: block;"> {{ $products[0]->detail_description }}
            </div>
            <div id="shippingReturnTab" class="tabcontent"> {{ $products[0]->detail_description }} </div>

        @endif

    </section>

@endsection


@section('customJs')
    <script>
        // Add TO Cart Functionality
        function addToCart(productId, productTitle, productPrice) {
            var imageId = document.getElementById('selectedImageId').value;
            var quantity = document.getElementById('quantity_input').value;
            $.ajax({
                url: "{{ route('front.addToCart') }}",
                type: "POST",
                data: {
                    id: productId,
                    title: productTitle,
                    price: productPrice,
                    quantity: quantity,
                    image_id: imageId
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == true) {
                        console.log("Successfull");
                        toastr.success(response.message);
                        window.location.href = "{{ route('front.cart') }}";

                    } else {
                        console.log("Error");
                        alert(response.message);
                    }
                }
            })
        }

        // Swap Images
        function swapImage(imagePath) {
            document.getElementById('mainImage').src = imagePath;
            document.getElementById('selectedImageId').value = imageId;
        }

        // Tabs
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector(".tablinks.active").click();
        });
    </script>
@endsection
