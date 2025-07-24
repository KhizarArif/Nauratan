@extends('frontend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="slider-wrapper">
        <div class="slider">
            <img id="1" src="{{ asset('frontend_assets/img/slider/Slider_01.jpg') }}" alt="First Image " class="slider_image">
            <img id="2" src="{{ asset('frontend_assets/img/slider/Slider_03.jpg') }}" alt="Third Image " class="slider_image">
        </div>
    </div>
    <div class="slider-nav">
        <a href="#1"></a>
        <a href="#2"></a>
    </div>
</div>

@include('frontend.categories')

@endsection

@section('customJs')
<script>
    $('.add').click(function() {
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

            // updateCart(rowId, newQty, $(this));
        }
    });

    $('.sub').click(function() {
        var qtyElement = $(this).parent().next();
        var qtyValue = parseInt(qtyElement.val());

        if (qtyValue > 1) {
            qtyElement.val(qtyValue - 1);

            var rowId = $(this).data('id');
            var newQty = qtyElement.val();

            // Show loader and disable buttons
            $(".loader").show();
            $('.sub').prop('disabled', true);

            // updateCart(rowId, newQty, $(this));
        }
    });
</script>
@endsection