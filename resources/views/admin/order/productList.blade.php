@extends('admin.layouts.app')

@section('title', 'Order Info')

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
                            <h2 class="title-1">Order Info</h2>
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
                    {{-- <div class="col-3 offset-9">
                        <form action="" method="GET">
                            @csrf
                            <div class="d-flex ">
                                <input type="text" name="key" class="form-control mt-0" placeholder="Search..." value="{{ request('key') }}">
                                <button class="btn btn-dark text-white" type="submit">
                                    <i class="bi bi-search-heart-fill"></i>
                                </button>
                            </div>
                        </form>
                    </div> --}}
                </div>
                <br>

                <div class="row col-5">
                    <div class="card mt-4">
                        <div class="card-body">
                            <h3> <i class="bi bi-list-ol"></i> Order Info</h3>
                            <small class="text-warning mt-3"> <i class="bi bi-exclamation-circle-fill"></i> Include Delivery Charges</small>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col"> <i class="bi bi-person-fill"></i> Customer Name</div>
                                <div class="col">  {{$orderList[0]->user_name}}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col"><i class="bi bi-upc"></i> Order Code</div>
                                <div class="col">{{$orderList[0]->order_code}}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col"><i class="bi bi-calendar-check-fill"></i> Order Date</div>
                                <div class="col">{{$orderList[0]->created_at->format('F-j-y')}}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col"><i class="bi bi-coin"></i> Total</div>
                                <div class="col">{{$order->total_price}} Kyats</div>
                            </div>
                        </div>
                    </div>
                </div>



            <div class="table-responsive table-responsive-data2">
                <table class="table table-data2">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Order ID</th>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th>Order Date</th>
                        </tr>
                    </thead>
                    <tbody id="dataList">
                        @foreach ($orderList as $o )
                        <tr class="tr-shadow my-2">
                            <td></td>
                            <td>{{ $o->id}}</td>
                            <td class="col-2"><img src="{{asset('storage/'.$o->product_image)}}" class="img-thumbnail shadow-sm" style="width: 100px;"></td>
                            <td>{{$o->product_name}}</td>
                            <td>{{$o->Qty}}</td>
                            <td >{{ $o->total_amount }}</td>
                            <td>{{$o->created_at->format('F-j-y')}}</td
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    <a href="{{route('order#list')}}" class="btn btn-success"><i class="bi bi-arrow-bar-left"></i> Back</a>
                </div>
                <!-- Pagination Links -->
                <div class="mt-3">
                    {{-- {{$orders->links()}} --}}
                </div>
            </div>

            </div>
        </div>
    </div>
</div>
@endsection
{{-- @section('scriptSource')
<script>
    $(document).ready(function(){
        $('#orderStatus').change(function(){
            $status = $('#orderStatus').val();
            $.ajax({
                type: 'get',
                url: "{{route('order#ajaxStatus')}}",
                data: {
                    status: $status,

                },
                dataType: 'json',
                success: function(response){
                    let listHtml = '';
                    response.forEach(order => {
                        listHtml += `
                             <tr class="tr-shadow my-2">
                            <td> ${order.user_id}</td>
                            <td>${order.user_name }</td>
                            <td>${new Date(order.created_at).toLocaleDateString('en-GB', {
                                day: 'numeric', month: 'long', year: 'numeric'
                            })}</td>
                            <td>${order.order_code }</td>
                            <td>${order.total_price}</td>
                            <td class="align-middle">
                                <select name="status" class="form-control statusChange">
                                    <option value="0" ${order.status == 0 ? 'selected' : ''}>  Pending</option>
                                    <option value="1" ${order.status == 1 ? 'selected' : ''}>  Success</option>
                                    <option value="2" ${order.status == 2 ? 'selected' : ''}>  Reject</option>
                                </select>

                            </td>
                        </tr>
                        `;
                    });
                    $('#dataList').html(listHtml);
                }
            })
        });

        // status change event
        $(document).on('change', '.statusChange', function () {
            $currentStatus = $(this).val();
            $parentNode = $(this).parents("tr");
            $orderId = $parentNode.find('.orderId').val();

            $.ajax({
                type: 'get',
                url: "{{route('order#ajaxStatusChange')}}",
                data: {
                    'status' : $currentStatus,
                    'orderId': $orderId
                },
                dataType: 'json'
            })
        });
    });
</script>
@endsection --}}
