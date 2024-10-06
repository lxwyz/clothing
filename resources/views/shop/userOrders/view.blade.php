@extends('shop.layouts.app')

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
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($orders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Product Name</th>
                                                <th>Customer Name</th>
                                                <th>Customer Email</th>
                                                <th>Quantity</th>
                                                <th>Status</th>
                                                <th>Order Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->product->name }}</td>
                                                    <td>{{ $order->customer_name }}</td>
                                                    <td>{{ $order->customer_email }}</td>
                                                    <td>{{ $order->quantity }}</td>
                                                    <td>{{ ucfirst($order->status) }}</td>
                                                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
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
