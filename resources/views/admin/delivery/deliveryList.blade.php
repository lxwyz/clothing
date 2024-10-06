@extends('admin.layouts.app')

@section('title', 'Shop List')

@section('content')
<!-- MAIN CONTENT -->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- Shop List Header -->
                <div class="table-data__tool">
                    <div class="table-data__tool-left">
                        <div class="overview-wrap">
                            <h2 class="title-1">Shop Lists</h2>
                        </div>
                    </div>
                    <div class="table-data__tool-right">
                        <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                            CSV download
                        </button>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="row">
                    <div class="col-3">
                        <h4 class="text-secondary">Search Key: <span class="text-danger">{{ request('key') }}</span></h4>
                    </div>
                    <div class="col-3 offset-9">
                        <form action="" method="GET">
                            @csrf
                            <div class="d-flex ">
                                <input type="text" name="key" class="form-control" placeholder="Search..." value="{{ request('key') }}">
                                <button class="btn btn-dark text-white" type="submit">
                                    <i class="bi bi-search-heart-fill"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <br>

                <!-- Shop Table -->
                @if ($deliveryPersons->count() > 0)
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($deliveryPersons as $dP)
                                    <tr class="tr-shadow">
                                        <td>
                                            <img src="{{ asset('storage/' . $dP->image) }}" style="width: 100px;" alt="Shop Image">
                                        </td>
                                        <td>{{ $dP->name }}</td>
                                        <td>{{ $dP->email }}</td>
                                        <td>{{ $dP->address }}</td>
                                        <td>{{ $dP->phone }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                <!-- View Shop -->
                                                <a href="{{ route('delivery#viewDelivery', $dP->id) }}">
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="View">
                                                        <i class="bi bi-view-list"></i>
                                                    </button>
                                                </a>
                                                <!-- Delete Shop -->
                                                <form action="{{ route('delivery#deleteDelivery', $dP->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this shop?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
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
                @else
                    <h3 class="text-secondary text-center mt-5">There are no shops available.</h3>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
