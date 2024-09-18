@extends('user.layouts.master')
@section('content')
<div class="container-fluid">
    <br>
    <a href="{{route('user#home')}}" class="nav-item nav-link text-dark">
       <button class="btn btn-sm btn-primary">Home</button>
    </a>
    <br>
    <div class="row px-xl-5">
        <div class="col-lg-8 table-responsive mb-5 offset-2">
            <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                <thead class="thead-dark">
                    <tr>
                        <th>Price</th>
                        <th>Order Code</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody class="align-middle">
                    @foreach ($order as $o)
                        <tr>
                            <td class="align-middle">{{$o->total_price}}</td>
                            <td class="align-middle">{{$o->order_code}}</td>
                            <td class="align-middle">
                                @if ($o->status == 0)
                                    <span class="text-warning"><i class="bi bi-alarm me-2"></i> Pending</span>
                                @elseif ($o->status ==1)
                                    <span class="text-success"> <i class="bi bi-check-lg me-2"></i> Success</span>
                                @elseif($o->status == 2)
                                    <span class="text-danger"> <i class="bi bi-ban me-2"></i> Reject</span>
                                @endif
                            </td>
                            <td class="align-middle">{{$o->created_at}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <span>
                {{ $order->links() }}
            </span>
        </div>
        </div>

    </div>
</div>
@endsection

