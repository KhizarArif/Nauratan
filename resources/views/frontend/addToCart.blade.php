@extends('frontend.layouts.app')

@section('content')


    <section class="container my-4">

        @if ($products[0] != null)

            <form class="row" id="addToCartForm">
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
                    <div class="product-details">
                        <h3 name="title" value="{{ $products[0]->title }}"> {{ $products[0]->title }} </h3>
                        <input type="hidden" name="$products[0]->title" value="{{ $products[0]->title }}">
                        <input type="hidden" name="product_id" value="{{ $products[0]->id }}">
                        <div class="d-flex">
                            <h5 class="price" name="price"> Rs. {{ number_format($products[0]->price, 2) }} </h5>
                            <h6 class="original_price" name="original_price">Rs.
                                {{ number_format($products[0]->original_price, 2) }} </h6>
                        </div>


                        <div class="mt-4 d-flex align-items-end justify-content-between">
                            <div class="col-md-3 p-0">
                                <p>Quantity</p>
                                <div class="input-group quantity border border-dark rounded">

                                    <button class="btn btn-outline-dark border border-none  btn-bold" type="button"
                                        id="decrement_btn">-</button>

                                    <input type="text" class="text-center border border-none" id="quantity_input"
                                        name="quantity" value="1" style="width: 2rem;">

                                    <button class="btn btn-outline-dark border border-none  btn-bold " type="button"
                                        id="increment_btn">+</button>

                                </div>
                            </div>

                        </div>

                        <a href="javascript:void(0)" class="btn btn-outline-dark my-3 w-100"
                            onclick="addToCart('{{ $products[0]->id }}', '{{ $products[0]->title }}', '{{ $products[0]->price }}')">Add
                            to cart
                        </a>

                        {{-- <div class="additional-actions d-flex justify-content-between mt-4">
                    <a href="#" class="text-decoration-none"><i class="fas fa-exchange-alt"></i>
                        Compare
                    </a>
                    <a href="#" class="text-decoration-none"><i class="far fa-question-circle"></i> Ask a
                        question
                    </a>
                    <a href="#" class="text-decoration-none"><i class="fas fa-share-alt"></i> Share</a>
                </div> --}}
                    </div>
                </div>
            </form>

            <div class="description_container">
                <div class="tablinks" onclick="openCity(event, 'descriptionTab')"> Product Description </div>
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
            var quantity = document.getElementById('quantity-input').value;
            $.ajax({
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