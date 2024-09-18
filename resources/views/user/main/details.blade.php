@extends('user.layouts.master')
@section('content')


    <div class="container-fluid pb-5">
        <a href="{{route('user#home')}}" class="nav-item nav-link text-dark">Home</a>
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('storage/'.$product->image)}}">
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30">
                <div class="h-100 bg-light p-30">
                    <h3>{{$product->name}}</h3>
                    <input type="hidden" name="" value="{{Auth::user()->id}}" id="userId">
                    <input type="hidden" name="" value="{{$product->id}}" id="productId">
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                        <small class="pt-1">(99 Reviews)</small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{$product->price}} kyats</h3>
                    <p class="mb-4">{{$product->description}}</p>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center" value="1" id="orderCount">

                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" id="addCartBtn" class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To
                            Cart</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">

                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            @foreach ($productsList as $p)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-item bg-light">
                        <div class="product-img position-relative overflow-hidden">
                            <img class="img-fluid w-100" src="{{ asset('storage/' . $p->image) }}" alt="" style="height: 300px">
                            <div class="product-action">
                                <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                <a class="btn btn-outline-dark btn-square" href="#"><i class="bi bi-eye"></i></a>
                            </div>
                        </div>
                        <div class="text-center py-4">
                            <a class="h6 text-decoration-none text-truncate" href="#">{{ $p->name }}</a>
                            <div class="d-flex align-items-center justify-content-center mt-2">
                                <h5>{{ $p->price }} kyats</h5>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
@endsection
@section('scriptSource')
<script>
    $(document).ready(function() {
        // Handling the Plus Button
        $('.btn-plus').click(function(){
            var quantity = parseInt($('#orderCount').val());  // Get the current quantity
            $('#orderCount').val(quantity + 1);  // Increment and update the value
        });

        // Handling the Minus Button
        $('.btn-minus').click(function(){
            var quantity = parseInt($('#orderCount').val());  // Get the current quantity
            if (quantity > 1) {
                $('#orderCount').val(quantity - 1);  // Decrement and update, ensuring value doesn't go below 1
            }
        });

        // Handle Add to Cart Button Click
        $('#addCartBtn').click(function (){

            // Get values from the input fields
            var count = $('#orderCount').val();
            var userId = $('#userId').val();
            var productId = $('#productId').val();

            // Prepare the data to send
            var source = {
                'userId' : userId,
                'productId' : productId,
                'count' : count,
                '_token': '{{ csrf_token() }}'  // Add CSRF token for security
            };

            // Make AJAX request
            $.ajax({
                type: 'POST',
                url: '{{ route("ajax#addToCart") }}',  // Correct Laravel route
                data: source,
                dataType: 'json',
                success: function(response) {
                    console.log(response);  // Show success message in console
                    alert(response.message);  // Show success message in an alert
                },

            });

        });
    });
</script>
@endsection
