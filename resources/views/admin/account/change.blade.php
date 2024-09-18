@extends('admin.layouts.app')

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
                            <div class="image">
                                <img src="{{asset('admin/images/icon/avatar-01.jpg')}}"/>
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#">{{Auth::user()->name}}</a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    <div class="image">
                                        <a href="#">
                                            <img src="{{asset('admin/images/icon/avatar-01.jpg')}}" alt="John Doe" />
                                        </a>
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
                                        <a href="{{route('admin#details')}}">
                                            <i class="zmdi zmdi-account"></i>Account</a>
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
                            <i class="bi bi-key"></i>Change Password</h3>
                        </div>
                        <hr>
                        <form action="{{route('admin#changePassword')}}" method="post" novalidate="novalidate">
                            @csrf
                            <div class="form-group">
                                <label class="control-label mb-1">Old Password</label>
                                <input id="oldPassword" name="oldPassword" type="password" class="form-control
                                @if (session('notMatch'))
                                    is-invalid
                                @endif
                                 @error('oldPassword') is-invalid @enderror"  aria-required="true" aria-invalid="false" placeholder="Enter Your Old Password">
                                @error('oldPassword')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                                @if(session('notMatch'))
                                    <div class="invalid-feedback">
                                        {{session('notMatch')}}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">New Password</label>
                                <input id="newPassword" name="newPassword" type="password" class="form-control @error('newPassword') is-invalid @enderror"  aria-required="true" aria-invalid="false" placeholder="Enter Your New Password">
                                @error('newPassword')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1">Confrim Password</label>
                                <input id="confirmPassword" name="confirmPassword" type="password" class="form-control @error('confirmPassword') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Confirm Password">
                                @error('confirmPassword')
                                    <div class="invalid-feedback">
                                        {{$message}}
                                    </div>
                                @enderror
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <a href="{{route('category#list')}}" class="btn btn-lg  btn-secondary">
                                    <i class="fa fa-arrow-left me-2"></i> Back
                                </a>
                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                    <span id="">Change Password</span>
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
