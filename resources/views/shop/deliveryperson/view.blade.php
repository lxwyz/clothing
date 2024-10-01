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
                                    @if (Auth::user()== 'female')
                                        <div class="image">
                                            <img src="{{asset('image/placeholder-female.jpg')}}" class="img-thumbnail shadow-sm" />
                                        </div>
                                    @else
                                        <div class="image">
                                            <img src="{{ asset('image/default_user3.png') }}" />
                                        </div>
                                    @endif
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
                                        @if (Auth::user()->gender == 'female')
                                            <div class="image shadow-sm">
                                                <img src="{{asset('image/placeholder-female.jpg')}}" class="img-thumbnail shadow-sm"/>
                                            </div>
                                        @else
                                            <div class="image">
                                                <img src="{{ asset('image/default_user3.png') }}" />
                                            </div>
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
                        <div class="card-title">
                            <h3 class="password-center title-2 text-center">Account Info</h3>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-3 offset-2 box-shadow">
                                @if ($deliveryPerson->image == null)
                                       @if ($deliveryPerson->gender == 'female')
                                            <div class="image">
                                                <img src="{{asset('image/placeholder-female.jpg')}}" class="img-thumbnail shadow-sm" />
                                            </div>
                                       @else
                                            <div class="image">
                                                <img src="{{ asset('image/default_user3.png') }}" />
                                            </div>
                                       @endif
                                @else
                                    <div class="image">
                                        <a href="#">
                                            <img src="{{asset('storage/'.$deliveryPerson->image)}}" class="img-thumbnail shadow-sm" />
                                        </a>
                                    </div>
                                @endif
                            </div>
                            <div class="col-5 offset-2 ">
                                <h4 class="my-3"> <i class="bi bi-pencil-square me-2"></i> {{$deliveryPerson->name}}</h4>
                                <h4 class="my-3"> <i class="bi bi-envelope-open-heart-fill me-2"></i> {{$deliveryPerson->email}}</h4>
                                <h4 class="my-3"> <i class="bi bi-person-vcard-fill me-2"></i> {{$deliveryPerson->address}}</h4>
                                <h4 class="my-3"> <i class="bi bi-phone me-2"></i> {{$deliveryPerson->phone}}</h4>
                                <h4 class="my-3"> <i class="bi bi-gender-ambiguous me-2">{{$deliveryPerson->gender}}</i></h4>
                                <h4 class="my-3"><i class="bi bi-calendar-date-fill me-2"></i> {{$deliveryPerson->created_at->format('j-F-y')}}</h4>
                                <br>
                                <a href="{{route('deliveryPerson#list')}}">
                                    <button class="btn bg-danger text-white">
                                        <i class="fas fa-backward"></i> Back
                                    </button>
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4 offset-2 mt-3">
                               <a href="{{route('deliveryPerson#edit',$deliveryPerson->id)}}">
                                    <button class="btn bg-dark text-white">
                                        <i class="bi bi-pencil-square"></i> Edit Profile
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
