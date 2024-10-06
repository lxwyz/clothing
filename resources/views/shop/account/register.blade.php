@extends('shop.layouts.app')
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
                            <h3 class="text-center title-2">Shop Register Form</h3>
                        </div>
                        <hr>
                        <form action="{{ route('shop#store') }}" method="post" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label mb-1">Name</label>
                                <input id="cc-pament" name="shopName" type="text" value="{{ old('shopName') }}" class="form-control @error('shopName') is-invalid @enderror" placeholder="Enter Name" aria-required="true" aria-invalid="false">
                                @error('shopName')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">Email</label>
                                <input id="cc-pament" name="shopEmail" type="text" value="{{ old('shopEmail') }}" class="form-control @error('shopEmail') is-invalid @enderror" placeholder="Enter Email" aria-required="true" aria-invalid="false">
                                @error('shopEmail')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">Phone</label>
                                <input id="cc-pament" name="shopPhone" type="text" value="{{ old('shopPhone') }}" class="form-control @error('shopPhone') is-invalid @enderror" placeholder="Enter Phone" aria-required="true" aria-invalid="false">
                                @error('shopPhone')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">Password</label>
                                <input id="cc-pament" name="shopPassword" type="password" value="{{ old('shopPassword') }}" class="form-control @error('shopPassword') is-invalid @enderror" placeholder="Enter Password" aria-required="true" aria-invalid="false">
                                @error('shopPassword')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <!-- Add Password Confirmation -->
                            <div class="form-group">
                                <label class="control-label mb-1">Confirm Password</label>
                                <input id="cc-pament" name="shopPassword_confirmation" type="password" class="form-control" placeholder="Confirm Password" aria-required="true" aria-invalid="false">
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">Address</label>
                                <textarea name="shopAddress" class="form-control @error('shopAddress') is-invalid @enderror" cols="30" rows="10">{{ old('shopAddress') }}</textarea>
                                @error('shopAddress')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label class="control-label mb-1">Image</label>
                                <input name="shopImage" type="file" class="form-control @error('shopImage') is-invalid @enderror">
                                @error('shopImage')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <br>
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="shopGender" class="form-control">
                                    <option value="male" {{ old('shopGender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('shopGender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('shopGender')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('products#list') }}" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left me-2"></i> Back
                                </a>
                                <button id="payment-button" type="submit" class="btn btn-info btn-block">
                                    <span id="payment-button-amount">Create</span>
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
