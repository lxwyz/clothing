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
                            <h3 class="text-center title-2">Product Form</h3>
                        </div>
                        <hr>
                        <form action="{{route('products#create')}}" method="post" novalidate="novalidate" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label class="control-label mb-1">Name</label>
                                <input id="productName" name="productName" type="text"  class="form-control @error('productName') is-invalid  @enderror" placeholder="Name">
                            </div>
                            @error('productName')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                            <div class="form-group mt-3">
                                <label class="control-label mb-1">Description</label>
                                <textarea name="productDescription" id="" cols="30" rows="10" class="form-control @error('productDescription') is-invalid @enderror"></textarea>
                            </div>
                            @error('productDescription')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                            <div class="form-group mt-3">
                                <label class="control-label mb-1">Category</label>
                                <select name="productCategory" class="form-control @error('productCategory') is-invalid @enderror">
                                    <option value="">Choose Your Category</option>
                                    @foreach ($categories as $cat )
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('productCategory')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                            <div class="form-group mt-3">
                                <label class="control-label mb-1">Image</label>
                                <input name="productImage" type="file"  class="form-control @error('productImage') is-invalid @enderror">
                            </div>
                            @error('productImage')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                            <div class="form-group mt-3">
                                <label class="control-label mb-1">Price</label>
                                <input id="cc-pament" name="productPrice" type="text"  class="form-control @error('productPrice') is-invalid @enderror" placeholder="Price">
                            </div>
                            @error('productPrice')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                            <br>
                            @if($shops->isEmpty())
                                <p>No shops available. Please create a shop first.</p>
                            @else
                                <select name="shop_id" class="form-control" required>
                                    @foreach ($shops as $shop)
                                        <option value="{{ $shop->id }}" class="form-control">{{ $shop->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                            </select>
                            <br>
                            <div class="d-flex justify-content-between">
                                <a href="{{route('products#list')}}" class="btn btn-secondary">
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
