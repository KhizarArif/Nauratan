{{-- Footer Start --}}
<footer class="bg-dark mt-5">
    <div class="container-fluid footer py-6 my-6 mb-0 wow bounceInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="footer-item">
                        <h1 class="text-primary">Art<span class="text-light">Wings</span></h1>
                        <p class="lh-lg mb-4 text-light"> Art Wings Where art meets precision. Handcrafted resin
                            creations for the modern home, sustainably made with love. </p>

                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer-item">
                        <h4 class="mb-4 text-light">Special Facilities</h4>
                        <div class="d-flex flex-column align-items-start">
                            <a class="mb-3" href=""><i class="fa fa-check text-primary me-2"></i>Jewellery</a>
                            <a class="mb-3" href=""><i class="fa fa-check text-primary me-2"></i>Wall Clock</a>
                            <a class="mb-3" href=""><i class="fa fa-check text-primary me-2"></i>Costers</a>
                            <a class="mb-3" href=""><i class="fa fa-check text-primary me-2"></i>Candles</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer-item">
                        <h4 class="mb-4 text-light">Contact Us</h4>
                        <div class="d-flex flex-column align-items-start">
                            <p><i class="fa fa-map-marker-alt text-primary me-2"></i> Faisalabad, Pakistan</p>
                            <p><i class="fa fa-phone-alt text-primary me-2"></i> (+92) 324 9660909</p>
                            <p><i class="fas fa-envelope text-primary me-2"></i> artwingsbysm@gmail.com </p>
                            <p><i class="fa fa-clock text-primary me-2"></i> 24/7 Hours Service</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="copyright-area bg-light text-dark">
        <div class="container">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="copy-right text-center">
                        <p> © Copyright 2024 Art Wings. All Rights Reserved </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

{{-- Footer END --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- <script>
    document.getElementById('increment_btn').addEventListener('click', function() {
        const quantityValue = document.getElementById('quantity_input');
        const currentValue = parseInt(quantityValue.value);
        quantityValue.value = currentValue + 1;
    });

    document.getElementById('decrement_btn').addEventListener('click', function() {
        const quantityValue = document.getElementById('quantity_input');
        const currentValue = parseInt(quantityValue.value);
        quantityValue.value = currentValue - 1;
    });
</script> -->


<script>

    const navbar = document.getElementById("main-navbar")

    window.addEventListener('scroll', function () {
        if (window.pageYOffset > 0) {
            navbar.classList.add("navbar-after-scroll")
        } else {
            navbar.classList.remove("navbar-after-scroll")
        }
    })


    $('.add').click(function () {
        var qtyElement = $(this).parent().prev();
        var qtyValue = parseInt(qtyElement.val());

        if ($('div').hasClass('alert-danger')) {
            return;
        }

        if (qtyValue < 10) {
            qtyElement.val(qtyValue + 1);

            var rowId = $(this).data('id');
            var newQty = qtyElement.val();

            // Show loader and disable buttons
            $(".loader").show();
            $('.add').prop('disabled', true);

            updateCart(rowId, newQty, $(this));
        }
    });

    $('.sub').click(function () {
        var qtyElement = $(this).parent().next();
        var qtyValue = parseInt(qtyElement.val());

        if (qtyValue > 1) {
            qtyElement.val(qtyValue - 1);

            var rowId = $(this).data('id');
            var newQty = qtyElement.val();

            // Show loader and disable buttons
            $(".loader").show();
            $('.sub').prop('disabled', true);

            updateCart(rowId, newQty, $(this));
        }
    });

    function updateCart(rowId, qty, button) {
        console.log("rowId", rowId);
        $size = $("#size").val();
        $.ajax({
            url: "{{ route('front.updateCart') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                rowId: rowId,
                qty: qty,
                size: $size
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status == false) {
                    alert(response.message);
                    $('.add, .sub').prop('disabled', false);
                }
                window.location.reload();
            },
            complete: function () {
                // Hide loader and enable buttons
                $('.loader').hide();
                $('.add, .sub').prop('disabled', false);
            }
        })
    }

    function deleteToCart(rowId) {
        if (confirm("Are you sure You want to delete ?")) {
            $.ajax({
                url: "{{ route('front.deleteToCart') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "delete",
                data: {
                    rowId: rowId
                },
                dataType: 'json',
                success: function (response) {
                    window.location.reload();
                }
            })

        }
    }
</script>

<!-- <script>
    const navbar = document.getElementById("main-navbar")

    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 0) {
            navbar.classList.add("navbar-after-scroll")
        } else {
            navbar.classList.remove("navbar-after-scroll")
        }
    })



    function addToCart(productId, productImageId = null, feature = null) {
        console.log("productId: ", productId, "productImageId: ", productImageId);
        $.ajax({
            url: "{{ route('front.addToCart') }}",
            type: "POST",
            data: {
                id: productId,
                image_id: productImageId,
                feature: feature
            },
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);
                if (response.status == true) {
                    window.location.href = "{{ route('front.cart') }}";
                } else {
                    console.log("Error");
                    toastr.error(response.message);
                }
            }
        })
    }
</script> -->

@yield('customJs')

</body>

</html>
