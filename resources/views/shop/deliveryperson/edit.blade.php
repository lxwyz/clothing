
@extends('shop.layouts.app')

@section('title','Delivery Person Account Edition')


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
                                    @if (Auth::user()->gender == 'female')
                                        <div class="image">
                                            <img src="{{ asset('image/placeholder-female.jpg') }}" />
                                        </div>
                                    @else
                                        <div class="image">
                                            <img src="{{ asset('image/default_user3.png') }}" />
                                        </div>
                                    @endif
                                @else
                                    <div class="image">
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}" />
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
                                            <div class="image">
                                                <img src="{{ asset('image/placeholder-female.jpg') }}" />
                                            </div>
                                        @else
                                            <div class="image">
                                                <img src="{{ asset('image/default_user3.png') }}" />
                                            </div>
                                        @endif
                                    @else
                                        <div class="image">
                                            <img src="{{ asset('storage/' . Auth::user()->image) }}" />
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
                                        <a href="{{route('deliveryPerson#list')}}">
                                            <i class="zmdi zmdi-accounts"></i>Delivery Person List</a>
                                    </div>
                                </div>
                                {{-- <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="{{route('admin#changePasswordPage')}}">
                                            <i class="bi bi-key"></i>Change Password</a>
                                    </div>
                                </div> --}}
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
                        @if(session('success'))
                            <div >
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-lg"></i>{{session('success')}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        @endif
                        <div class="card-title">
                            <h3 class="password-center title-2 text-center">Account Profile</h3>
                        </div>
                        <hr>
                        <form action="{{route('deliveryPerson#update',$deliveryPerson->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- Profile Picture -->
                                <div class="col-4 offset-1">
                                    @if ($deliveryPerson->image == null)
                                        @if ($deliveryPerson->gender == 'female')
                                            <div class="image">
                                                <img src="{{ asset('image/placeholder-female.jpg') }}" />
                                            </div>
                                        @else
                                            <div class="image">
                                                <img src="{{ asset('image/default_user3.png') }}" />
                                            </div>
                                        @endif
                                    @else
                                        <a href="#">
                                            <img src="{{asset('storage/'.$deliveryPerson->image)}}" class="img-thumbnail shadow-sm" />
                                        </a>
                                    @endif
                                    <div class="mt-3">
                                        <input type="file" name="image"  class="form-control">
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
                                        <input name="name" type="text" value="{{old('name',$deliveryPerson->name)}}" class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter Your Name">
                                    </div>
                                    @error('name')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                    <div class="form-group">
                                        <label class="control-label mb-1">Email</label>
                                        <input name="email" type="email" class="form-control" value="{{old('email',$deliveryPerson->email)}}" aria-required="true" aria-invalid="false" placeholder="Enter Your Email">
                                    </div>
                                    @error('email')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                    <div class="form-group">
                                        <label class="control-label mb-1">Address</label>
                                        <textarea name="address" id="" cols="30" rows="10" class="form-control">{{old('address',$deliveryPerson->address)}}</textarea>
                                    </div>
                                    @error('address')
                                        <div class="text-danger">{{$message}}</div>
                                    @enderror
                                    <div class="form-group">
                                        <label for="Gender">Gender</label>
                                        <select name="gender" id="" class="form-control">
                                            <option value="">Choose Gender</option>
                                            <option value="male" @if ($deliveryPerson->gender == 'male') selected @endif>Male</option>
                                            <option value="female" @if ($deliveryPerson->gender == 'female') selected @endif>Female</option>
                                        </select>
                                        @error('gender')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Phone</label>
                                        <input name="phone" type="text" class="form-control" value="{{old('phone',$deliveryPerson->phone)}}" aria-required="true" aria-invalid="false" placeholder="Enter Your Phone">
                                    </div>
                                        @error('gender')
                                            <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    <br>
                                        <div class="form-group">
                                            <label class="control-label mb-1">Password</label>
                                            <input id="cc-pament" name="deliveryPersonPassword" type="password" value="{{ old('deliveryPersonPassword',$deliveryPerson->password) }}" class="form-control @error('deliveryPersonPassword') is-invalid @enderror" placeholder="Enter Password" aria-required="true" aria-invalid="false">
                                            @error('deliveryPersonPassword')
                                                <div class="invalid-feedback">
                                                    {{$message}}
                                                </div>
                                            @enderror
                                        </div>
                                    <a href="{{route('deliveryPerson#list')}}" class="btn btn-default">Back</a>
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

