@extends('deliveryPersons.layouts.app')

@section('content')
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Customer Orders</h3>
                            </div>
                            <hr>

                            {{-- Success Message --}}
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
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



                            {{-- Orders Table --}}
                            @if ($orders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer Name</th>
                                                <th>Customer Email</th>
                                                <th>Order Date</th>
                                                <th>Order Code</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="dataList">
                                            @foreach ($orders as $order )
                                            <tr class="tr-shadow my-2">
                                                <input type="hidden" class="orderId" value="{{$order->id}}">
                                                <td>{{ $order->user_id}}</td>
                                                <td>{{ $order->user_name }}</td>
                                                <td>{{$order->user_email}}</td>
                                                <td>{{ $order->created_at->format('j-F-y') }}</td>
                                                <td>
                                                    <a href="{{route('order#listInfo',$order->order_code)}}" class="text-primary">{{ $order->order_code }}</a>
                                                </td>
                                                <td class="amount">{{ $order->total_price }}</td>
                                                <td class="align-middle">
                                                    <select name="status" class="form-control statusChange">
                                                        <option value="0" @if($order->status == 0) selected @endif>  Pending</option>
                                                        <option value="1" @if($order->status == 1) selected @endif>  Success</option>
                                                        <option value="2"@if($order->status == 2) selected @endif>  Reject</option>
                                                    </select>

                                                </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                {{ $orders->links() }} <!-- Pagination links -->
                            @else
                                <div class="alert alert-warning">
                                    No orders found.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scriptSource')
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
@endsection
