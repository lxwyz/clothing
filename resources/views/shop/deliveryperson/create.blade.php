@extends('shop.layouts.app')
@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">

            </div>
            <div class="col-lg-6 offset-3">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h3 class="text-center title-2">Delivery Register Form</h3>
                        </div>
                        <hr>
                        <form action="{{ route('deliveryPerson#store') }}" method="post" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label mb-1">Name</label>
                                <input id="cc-payment" name="deliveryPersonName" type="text" value="{{ old('deliveryPersonName') }}" class="form-control @error('deliveryPersonName') is-invalid @enderror" placeholder="Enter Name" aria-required="true" aria-invalid="false">
                                @error('deliveryPersonName')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">Email</label>
                                <input id="cc-payment" name="deliveryPersonEmail" type="text" value="{{ old('deliveryPersonEmail') }}" class="form-control @error('deliveryPersonEmail') is-invalid @enderror" placeholder="Enter Email" aria-required="true" aria-invalid="false">
                                @error('deliveryPersonEmail')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">Phone</label>
                                <input id="cc-payment" name="deliveryPersonPhone" type="text" value="{{ old('deliveryPersonPhone') }}" class="form-control @error('deliveryPersonPhone') is-invalid @enderror" placeholder="Enter Phone" aria-required="true" aria-invalid="false">
                                @error('deliveryPersonPhone')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">Password</label>
                                <input id="cc-payment" name="deliveryPersonPassword" type="password" value="{{ old('deliveryPersonPassword') }}" class="form-control @error('deliveryPersonPassword') is-invalid @enderror" placeholder="Enter Password" aria-required="true" aria-invalid="false">
                                @error('deliveryPersonPassword')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">Confirm Password</label>
                                <input id="cc-payment" name="deliveryPersonPassword_confirmation" type="password" value="{{ old('deliveryPersonPassword_confirmation') }}" class="form-control @error('deliveryPersonPassword_confirmation') is-invalid @enderror" placeholder="Confirm Password" aria-required="true" aria-invalid="false">
                                @error('deliveryPersonPassword_confirmation')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">Address</label>
                                <textarea name="deliveryPersonAddress" class="form-control" cols="30" rows="10">{{ old('deliveryPersonAddress') }}</textarea>
                                @error('deliveryPersonAddress')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label class="control-label mb-1">Image</label>
                                <input name="deliveryPersonImage" type="file" class="form-control @error('deliveryPersonImage') is-invalid @enderror">
                            </div>
                            @error('deliveryPersonImage')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                            <br>

                            {{-- @if($shops->isEmpty())
                                <p>No shops available. Please create a shop first.</p>
                            @else
                                <select name="shop_id" class="form-control" required>
                                    <option value="">Select A Shop</option>
                                    @foreach ($shops as $shop)
                                        <option value="{{ $shop->id }}" class="form-control">{{ $shop->name }}</option>
                                    @endforeach
                                </select>
                            @endif --}}
                            <br>
                            <div class="form-group">
                                <label>Gender</label>
                                <select name="deliveryPersonGender" class="form-control">
                                    <option value="male" {{ old('deliveryPersonGender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('deliveryPersonGender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('deliveryPerson#list') }}" class="btn btn-secondary">
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
