@extends('admin.layouts.header')
@section('content')
<h4> Update Product </h4>
<form class="custom-validation" novalidate id="product_form">
    @csrf

    <input type="hidden" name="id" value="{{ isset($editProduct->id) ? $editProduct->id : null }}">

    <div class="row d-flex">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label"> Title </label>
                        <input type="text" class="form-control" name="title" id="title" placeholder=" Title "
                            value="{{ isset($editProduct->title) ? $editProduct->title : null }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label"> Slug </label>
                        <input type="text" class="form-control" name="slug" id="slug" placeholder=" Slug "
                            value="{{ isset($editProduct->slug) ? $editProduct->slug : null }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label"> Short Description. </label>
                        <input type="text" class="form-control" id="validationCustom01" name="short_description"
                            value="{{ isset($editProduct->short_description) ? $editProduct->short_description : null }}"
                            placeholder=" Short Description... " required>
                    </div>
                    <div class="mb-3">
                        <label for="validationCustom01" class="form-label"> Detail Description. </label>
                        <textarea class="form-control" placeholder=" Detail Description... " name="detail_description"
                            id="validationCustom01" rows="5" required>
                                {{ isset($editProduct->detail_description) ? $editProduct->detail_description : null }}
                            </textarea>
                    </div>
                    <div class="row">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Media</h2>
                                <div id="image" name="image" class="dropzone dz-clickable">
                                    <div class="dz-message needsclick">
                                        <br>Drop files here or click to upload.<br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="product_gallery">
                        @if ($productImages->isNotEmpty())
                            @foreach ($productImages as $image)
                                <div class="col-md-2" id="image-row-{{ $image->id }}">
                                    <div class="card">
                                        <input type="hidden" name="image_array[]" value="{{ $image->id }}">
                                        <img src="{{ asset('uploads/product/small/' . $image->image) }}" class="card-img-top"
                                            alt="...">
                                        <div class="card-body">
                                            <a href="javascript:void(0)" onClick="deleteImage( '{{ $image->id }}')"
                                                class="btn btn-danger btn-sm delete"> Delete </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="validationCustom01" class="form-label">Original Price </label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="number" id="validationCustom01"
                                        value="{{ isset($editProduct->original_price) ? $editProduct->original_price : null }}"
                                        name="original_price" placeholder=" Original Price.... " required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="validationCustom01" class="form-label"> Price </label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="number" id="validationCustom01"
                                        value="{{ isset($editProduct->price) ? $editProduct->price : null }}"
                                        name="price" placeholder=" Price.... " required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="validationCustom01" class="form-label"> Quantity </label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="number" id="validationCustom01"
                                        value="{{ isset($editProduct->qty) ? $editProduct->qty : null }}" name="qty"
                                        placeholder="Quantity.... " required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Secong Column --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5> Product Status </h5>
                    <div class="mb-3">
                        <label for="validationCustom03" class="form-label"> Status </label>
                        <select class="form-select" id="validationCustom03" name="status" required>
                            <option selected disabled value="">
                                Select option ...
                            </option>
                            <option value="active" {{ $editProduct->status == 'active' ? 'selected' : '' }}> Active
                            </option>
                            <option value="inactive" {{ $editProduct->status == 'inactive' ? 'selected' : '' }}>
                                InActive </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <h5> Product Category </h5>
                        <div class="mb-3">
                            <select class="form-select" id="validationCustom03" name="category_id" required>
                                <option selected disabled value="">
                                    Select option ...
                                </option>
                                @if ($categories != null)
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ isset($editProduct->category_id) && $editProduct->category_id == $category->id ? 'selected' : ''  }}> {{ $category->name }} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div>
        <button class="btn btn-primary" type="submit" id="submit_btn">Submit</button>
        <div id="submit_loader" style="display: none;">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</form>
</div>
</div>
<!-- end card -->
</div>
@endsection


@section('customJs')
<script>
    Dropzone.options.image = {
        url: "{{ route('products.updateImage') }}",
        maxFiles: 10,
        paramName: 'file',
        params: {
            'product_id': '{{ $editProduct->id }}',
            'slug': '{{ $editProduct->slug }}'
        },
        addRemoveLinks: true,
        acceptedFiles: "image/jpeg,image/png,image/gif, image/jpg, video/mp4, application/pdf",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (file, response) {
            console.log("success", response);
            var fileType = file.type.split('/')[0];
            var product = '';

            if (fileType === 'image') {
                product = `<div class="col-md-2 d-flex" id="image-row-${response.image_id}">
                <div class="card" >
                    <input type="hidden" name="image_array[]" value="${response.image_id}">
                    <img src="${response.ImagePath}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="javascript:void(0)" onclick="deleteImage(${response.image_id})" class="btn btn-danger btn-sm delete"> Delete </a>
                    </div>
                </div>
            </div>`;
            }

            $("#product_gallery").append(product);
        },
        complete: function (file) {
            this.removeFile(file);
        }
    };

    $('#title').change(function () {
        var element = $(this);
        $.ajax({
            type: "GET",
            url: "{{ route('getSlug') }}",
            data: {
                title: element.val()
            },
            dataType: "json",
            success: function (response) {
                if (response["status"] == true) {
                    $("#slug").val(response["slug"]);
                }
            }
        });
    });

    // function deleteImage(imageId) {
    //     $.ajax({
    //         url: "{{ route('delete.image', ['id' => ':imageId']) }}".replace(':imageId', imageId),
    //         type: 'DELETE',
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             if (response.success) {
    //                 $("#image-row-" + imageId).remove();
    //                 console.log("Image deleted successfully");
    //                 toastr.success(response.message);
    //             } else {
    //                 console.error("Error deleting image: ", response.message);
    //                 toastr.error(response.message);
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             console.error("Error deleting image: ", error);
    //         }
    //     });
    // }

    function deleteImage(imageId) {
        $.ajax({
            type: 'DELETE',
            data: {
                id: imageId
            },
            url: "{{ route('products.deleteImage') }}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    $("#image-row-" + imageId).remove(); // Remove image from UI
                    console.log("Image deleted successfully");
                    toastr.success(response.message);
                } else {
                    console.error("Error deleting image: ", response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error deleting image: ", error);
            }
        });
    }

    $("#product_form").submit(function (e) {
        e.preventDefault();
        $("#submit_btn").attr("disabled", true).hide();
        $("#submit_loader").show();

        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "{{ route('product.store') }}",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function (data) {
                console.log('AJAX request successful', data);
                if (data.status == true) {
                    toastr.success(data.message);
                    console.log("Successfull", data);
                    window.location.href = "{{ route('product.index') }}";

                } else {
                    toastr.error(data.error);
                }
            },
            error: function (xhr, status, error) {
                toastr.error("An error occurred. Please try again.");
                if (xhr.status === 422) {
                    var errors = $.parseJSON(xhr.responseText);
                    $.each(errors["errors"], function (key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                }
                console.error("AJAX request failed", status, error);
            },
            complete: function () {
                // Re-enable the submit button and hide loader
                $("#submit_btn").attr("disabled", false).show();
                $("#submit_loader").hide();
            },
        });
    })
</script>
@endsection
