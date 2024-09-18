@extends('admin.layouts.app')

@section('title', 'Order List')

@section('content')
<header class="header-desktop">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="header-wrap">
                <h2>Admin Dashboard Panel</h2>
                <div class="header-button">
                    <div class="noti-wrap">
                        <div class="noti__item js-item-menu"></div>
                    </div>
                    <div class="account-wrap">
                        <div class="account-item clearfix js-item-menu">
                            @if (Auth::user()->image == null)
                                <div class="image">
                                    <img src="{{ asset('image/default_user3.png') }}" />
                                </div>
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
                                        <div class="image">
                                            <img src="{{ asset('image/default_user3.png') }}" />
                                        </div>
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
                            <h2 class="title-1">Order Lists</h2>
                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        {{-- <a href="{{ route('products#createPage') }}">
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                <i class="zmdi zmdi-plus"></i>Add Products
                            </button>
                        </a> --}}
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            CSV download
                        </button>
                    </div>
                </div>

                @if(session('createSuccess'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-lg"></i>{{ session('createSuccess') }}
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
                        <form action="" method="GET">
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
              <div class="d-flex align-items-center">
                <label for="" class="mt-2 me-4">Order Status</label>
                <select id="orderStatus" class="form-control w-auto">
                    <option value="">All</option>
                    <option value="0">Pending</option>
                    <option value="1">Success</option>
                    <option value="2">Reject</option>
                </select>
              </div>


            <div class="table-responsive table-responsive-data2">
                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th>User Id</th>
                            <th>User Name</th>
                            <th>Order Date</th>
                            <th>Order Code</th>
                            <th>Amount</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order )
                        <tr class="tr-shadow my-2">
                            <td>{{ $order->user_id}}</td>
                            <td>{{ $order->user_name }}</td>
                            <td>{{ $order->created_at->format('j-F-y') }}</td>
                            <td>{{ $order->order_code }}</td>
                            <td>{{ $order->total_price }}</td>
                            <td class="align-middle">
                                <select name="status" class="form-control">
                                    <option value="0" @if($order->status == 0) selected @endif>  Pending</option>
                                    <option value="1" @if($order->status == 1) selected @endif>  Success</option>
                                    <option value="2"@if($order->status == 2) selected @endif>  Reject</option>
                                </select>
                                {{-- @if ($order->status == 0)
                                    <span class="text-warning"> Pending</span>
                                @elseif ($order->status ==1)
                                    <span class="text-success">  Success</span>
                                @elseif($order->status == 2)
                                    <span class="text-danger">  Reject</span>
                                @endif --}}
                            </td><!-- Display view_count -->
                            <td>
                                <div class="table-data-feature">
                                    {{-- <a href="{{ route('products#edit', $product->id) }}">
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="View">
                                            <i class="bi bi-view-list"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('products#updatePage', $product->id) }}">
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Edit">
                                            <i class="fas fa-pen-square"></i>
                                        </button>
                                    </a>
                                    <a href="{{ route('products#delete', $product->id) }}">
                                        <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </a> --}}
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <!-- Pagination Links -->
                <div class="mt-3">
                    {{$orders->links()}}
                </div>
            </div>

            </div>
        </div>
    </div>
</div>
@endsection
