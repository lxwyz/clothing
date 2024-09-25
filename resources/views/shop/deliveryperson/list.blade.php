@extends('shop.layouts.app')

@section('title', 'Product List')

@section('content')
<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <h2>Shop Admin Dashboard Panel</h2>
                <div class="header-button">
                    <div class="noti-wrap">
                        <div class="noti__item js-item-menu"></div>
                    </div>
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            @if (Auth::user()->image == null)
                                @if (Auth::user()->gender == 'male')
                                    <img src="{{ asset('image/default_user3.png' ) }}" class="img-thumbnail img-fluid shadow-sm">
                                @else
                                    <img src="{{asset('image/placeholder-female.jpg')}}" class="img-thumbnail img-fluid shadow-sm">
                                @endif
                            @else
                                <div class="image">
                                    <img src="{{ asset('storage/' . Auth::user()->image) }}" />
                                </div>
                            @endif
                            <div class="content">
                                <a class="js-acc-btn" href="#">{{ Auth::user()->name }}</a>
                            </div>
                            <div class="account-dropdown js-dropdown">
                                <div class="info clearfix">
                                    @if (Auth::user()->image == null)
                                        @if (Auth::user()->gender == 'male')
                                            <img src="{{ asset('image/default_user3.png' ) }}" class="img-thumbnail shadow-sm">
                                        @else
                                            <img src="{{asset('image/placeholder-female.jpg')}}" class="img-thumbnail shadow-sm">
                                        @endif
                                    @else
                                        <div class="image">
                                            <a href="#">
                                                <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="John Doe" />
                                            </a>
                                        </div>
                                    @endif
                                    <div class="content">
                                        <h5 class="name">
                                            <a href="#">{{ Auth::user()->name }}</a>
                                        </h5>
                                        <span class="email">{{ Auth::user()->email }}</span>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="{{ route('admin#details') }}">
                                            <i class="zmdi zmdi-account"></i>Account
                                        </a>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="{{ route('admin#list') }}">
                                            <i class="zmdi zmdi-accounts"></i>Admin List
                                        </a>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="{{ route('admin#changePasswordPage') }}">
                                            <i class="bi bi-key"></i>Change Password
                                        </a>
                                    </div>
                                </div>
                                <div class="account-dropdown__footer my-3">
                                    <form action="{{ route('logout') }}" method="post" class="d-flex justify-content-center">
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

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Delivery Person Lists</h2>
                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <a href="{{ route('deliveryPerson#create') }}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>Register Delivery Person
                            </button>
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-lg"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('deleteSuccess'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-lg"></i>{{ session('deleteSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row">
                    <div class="col-3">
                        <h4 class="text-secondary">Search Key: <span class="text-danger">{{ request('key') }}</span></h4>
                    </div>

                    <div class="col-3 offset-9">
                        <form action="{{ route('deliveryPerson#list') }}" method="GET">
                            @csrf
                            <div class="d-flex ">
                                <input type="text" name="key" class="form-control mt-0" placeholder="Search..." value="{{ request('key') }}">
                                <button class="btn btn-dark text-white" type="submit">
                                    <i class="bi bi-search-heart-fill"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <br>


            <div class="table-responsive table-responsive-data2">
                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Gender</th>
                            <th>Actions</th><!-- Added view_count header -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($deliveryPersons as $dP)
                        <tr class="tr-shadow my-2">
                            <tr class="tr-shadow my-2">
                                <td class="col-1">
                                    @if ($dP->image == null)
                                       @if ($dP->gender == 'male')
                                            <img src="{{ asset('image/default_user3.png' ) }}" class=" shadow-sm">
                                       @else
                                           <img src="{{asset('image/placeholder-female.jpg')}}" class=" shadow-sm">
                                       @endif
                                    @else
                                        <img src="{{ asset('storage/'.$dP->image) }}" class=" shadow-sm">
                                    @endif
                                </td>
                            <td>{{$dP->name}}</td>
                            <td>{{$dP->email}}</td>
                            <td>{{$dP->phone}}</td>
                            <td>{{$dP->address}}</td>
                            <td>{{$dP->gender}}</td>
                            <td>
                                <div class="table-data-feature">
                                    <a href="{{ route('deliveryPerson#view', $dP->id) }}">
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="View">
                                            <i class="bi bi-view-list"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('deliveryPerson#edit', $dP->id) }}">
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fas fa-pen-square"></i>
                                        </button>
                                    </a>
                                    <form action="{{ route('deliveryPerson#delete', $dP->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this delivery person? This action cannot be undone.');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Pagination Links -->
                <div class="mt-3">
                    {{ $deliveryPersons->links() }}
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
