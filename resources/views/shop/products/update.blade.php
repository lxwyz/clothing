@extends('shop.layouts.app')

@section('title','Category List')


@section('content')
<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <form class="form-header" action="" method="POST">
                    <input class="au-input au-input--xl" type="password" name="search" placeholder="Search for datas &amp; reports..." />
                    <button class="au-btn--submit" type="submit">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </form>
                <div class="header-button">
                    <div class="noti-wrap">
                        <div class="noti__item js-item-menu">



                        </div>
                    </div>
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image ">
                                @if (Auth::user()->image == null)
                                    @if (Auth::user()->gender == 'male')
                                        @if (Auth::user()->gender == 'male')
                                            <img src="{{ asset('image/default_user3.png' ) }}" class="img-thumbnail shadow-sm">
                                        @else
                                            <img src="{{asset('image/placeholder-female.jpg')}}" class="img-thumbnail img-fluid shadow-sm">
                                        @endif
                                    @else
                                        <img src="{{asset('image/placeholder-female.jpg')}}" class=" shadow-sm">
                                    @endif
                                @else
                                    <div class="image shadow-sm">
                                        <a href="#">
                                            <img src="{{asset('storage/'.Auth::user()->image)}}" class="img-thumbnail shadow-sm" />
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#">{{Auth::user()->name}}</a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                <div class="image">
                                   <div class="image shadow-sm">
                                    @if (Auth::user()->gender == 'male')
                                        <img src="{{ asset('image/default_user3.png' ) }}" class="img-thumbnail shadow-sm">
                                    @else
                                        <img src="{{asset('image/placeholder-female.jpg')}}" class="img-thumbnail img-fluid shadow-sm">
                                    @endif
                                    </div>



                                </div>
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#">{{Auth::user()->name}}</a>
                                        </h5>
                                        <span class="email">{{Auth::user()->email}}</span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="#">
                                            <i class="zmdi zmdi-account"></i>Account</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="{{route('admin#changePasswordPage')}}">
                                            <i class="zmdi zmdi-account"></i>Change Password</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer my-3">
                                    <form action="{{route('logout')}}" method="post" class="d-flex justify-content-center">
                                        @csrf
                                        <button class="btn bg-dark text-white col-10" type="submit">
                                             <i class="zmdi zmdi-power"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- HEADER DESKTOP-->

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
                            <h3 class="password-center title-2 text-center">Product Update</h3>
                        </div>
                        <hr>
                        <form action="{{route('products#update',$products->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Product Picture -->
                                <div class="col-4 offset-1">
                                    <img src="{{asset('storage/'.$products->image)}}" class="img-thumbnail shadow-sm" />
                                    <div class="mt-3">
                                        <input type="file" name="productImage"  class="form-control">
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-danger col-12 mt-3">
                                            <i class="zmdi zmdi-upload"></i>  Upload
                                        </button>
                                    </div>
                                </div>
                                <!-- Form Fields -->
                                <div class="row col-6">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input name="productName" type="text" value="{{ old('productName',$products->name) }}" class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter Product Name">
                                    </div>
                                    @error('productName')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                    <div class="form-group">
                                        <label class="control-label mb-1">Description</label>
                                        <textarea name="productDescription" class="form-control @error('productDescription') is-invalid @enderror" cols="30" rows="10">{{ old('productDescription',$products->description)}}</textarea>
                                    </div>
                                    @error('productDescription')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                    <div class="form-group">
                                        <label class="control-label mb-1">Price</label>
                                        <input type="number" class="form-control @error('productPrice') is-invalid @enderror" name="productPrice" value="{{old('productPrice',$products->price)}}">
                                    </div>
                                    @error('productPrice')
                                        <div class="text-danger">{{$message}}</div>
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

                                    <a href="{{route('products#list',$products->id)}}" class="btn btn-default">Back</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
