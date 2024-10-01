@extends('shop.layouts.app')

@section('title','Product List')


@section('content')


<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
            </div>
            <div class="col-lg-6 offset-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Register Shop Info</h3>
                        </div>
                        <hr>
                        <form action="{{ route('shop#store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <!-- Input fields -->
                            <div class="form-group">
                                <label class="control-label mb-1">Name</label>
                                <input id="name" name="name" type="text" class="form-control" placeholder="Name">
                            </div>
                            <div class="form-group mt-3">
                                <label class="control-label mb-1">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Address">
                            </div>
                            <div class="form-group mt-3">
                                <label class="control-label mb-1">Phone</label>
                                <input type="text" name="phone" class="form-control" placeholder="Phone Number">
                            </div>
                            <div class="form-group mt-3">
                                <label class="control-label mb-1">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password">
                            </div>
                            <div class="form-group mt-3">
                                <label class="control-label mb-1">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                            </div>
                            <div class="form-group mt-3">
                                <label class="control-label mb-1">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter Email">
                            </div>

                            <!-- Submit button -->
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('products#list') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left me-2"></i> Back
                                </a>
                                <button id="payment-button" type="submit" class="btn btn-info btn-block">
                                    <span id="payment-button-amount">Register</span>
                                    <i class="fa fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
