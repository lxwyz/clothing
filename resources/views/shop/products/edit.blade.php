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
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            <div class="image ">
                                @if (Auth::user()->image == null)
                                    <div class="image">
                                        <img src="{{asset('image/default_user3.png')}}" class="img-thumbnail shadow-sm" />
                                    </div>
                                @else
                                    <div class="image shadow-sm">
                                         <img src="{{asset('storage/'.Auth::user()->image)}}" class="img-thumbnail shadow-sm"/>
                                    </div>
                                @endif
                            </div>
                            <div class="content">
                                <a class="js-acc-btn" href="#">{{Auth::user()->name}}</a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                <div class="image">
                                    @if (Auth::user()->image == null)
                                        @if (Auth::user()->gender == 'male')
                                            img src="{{ asset('image/default_user3.png' ) }}" class=" shadow-sm">
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
    <div class="row">
        <col class="col-3 offset-7 bg-danger">
        @if(session('updateSuccess'))
             <div >
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-lg"></i>{{session('updateSuccess')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
             </div>
        @endif
    </div>
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">

            </div>
            <div class="col-lg-6 offset-3">
                <div class="card">
                    <div class="card-body">
                        <div class="ms-5">
                            <i class="bi bi-arrow-bar-left text-dark" onclick="history.back()"></i>
                        </div>

                        <div class="row">
                            <div class="col-3 offset-2">
                                 <div class="image">
                                    <img src="{{asset('storage/'.$products->image)}}" class="img-thumbnail shadow-sm" />
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="my-3 text-dark d-block w-50 fs-3 "> {{$products->name}}</div>
                                <span class="my-3 btn bg-dark text-white"> <i class="bi bi-tag-fill"></i> {{$products->price}} kyats</span>
                                <span class="my-3 btn bg-dark text-white"><i class="bi bi-eye-fill fs-6 me-2"></i> {{$products->view_count}}</span>
                                <span class="my-3 btn bg-dark text-white"><i class="bi bi-basket"></i> {{$products->category_id}}</span>
                                <span class="my-3 btn bg-dark text-white"> <i class="bi bi-calendar-date-fill fs-5 me-2"></i> {{$products->created_at->format('j-F-y')}}</span>
                                <div class="my-3"><i class="bi bi-card-heading"></i> Details </div>
                                <div>{{$products->description}}</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 offset-2 mt-3">
                               <a href="{{route('products#updatePage',$products->id)}}">
                                    <button class="btn bg-dark text-white">
                                        <i class="bi bi-pencil-square"></i> Update
                                    </button>
                               </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
