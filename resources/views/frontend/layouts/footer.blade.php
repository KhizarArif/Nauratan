{{-- Footer Start --}}
<footer class="footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>Let’s get in touch</h3>
            <p>Sign up for our newsletter and receive discounts & gifts</p>
            <form class="newsletter-form">
                <input type="email" placeholder="Enter your email" />
                <button type="submit">➔</button>
            </form>
        </div>
        <div class="footer-section">
            <h4>Shop Nauratan</h4>
            <ul>
                <li><a href="#">Search</a></li>
                <li><a href="#">Home</a></li>
                <li><a href="#">All products</a></li>
                <li><a href="#">Sale</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Information</h4>
            <ul>
                <li><a href="#">Contact</a></li>
                <li><a href="#">Refund Policy</a></li>
                <li><a href="#">Shipping Policy</a></li>
                <li><a href="#">Returns & Exchange Policy</a></li>
            </ul>
        </div>
        <div class="footer-section">
            <h4>Nauratan Herbals</h4>
            <p>Explore our collection of pure, herbal treasures to nurture your skin and hair naturally.</p>
            <p>+92 331 2818985</p>
            <p><a href="mailto:nauratanherbals@gmail.com">nauratanherbals@gmail.com</a></p>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© Nauratan Herbals 2023. Powered by Steps Global</p>
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

<script>
    document.getElementById('increment_btn').addEventListener('click', function () {
        const quantityValue = document.getElementById('quantity_input');
        const currentValue = parseInt(quantityValue.value);
        quantityValue.value = currentValue + 1;
    });

    document.getElementById('decrement_btn').addEventListener('click', function () {
        const quantityValue = document.getElementById('quantity_input');
        const currentValue = parseInt(quantityValue.value);
        quantityValue.value = currentValue - 1;
    });
</script>


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

        if (qtyValue < 50) {
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
