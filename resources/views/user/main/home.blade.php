@extends('user.layouts.master')

@section('content')
<div class="container-fluid bg-dark mb-30">
    <div class="row px-xl-5">

        <div class="col-lg-9">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav mr-auto py-0">
                        <a href="{{route('user#home')}}" class="nav-item nav-link active">Home</a>
                        <a href="" class="nav-item nav-link">My Cart</a>
                        <a href="" class="nav-item nav-link">Contact</a>
                    </div>
                    <div class="navbar-nav ml-auto py-0 d-none d-inline">
                        <a href="" class="btn px-0">
                            <i class="fas fa-heart text-primary"></i>
                            <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                        </a>
                        <a href="{{route('user#cartList')}}" class="btn px-0 ml-3">
                            <button type="button" class="btn bg-dark text-white position-relative">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                 <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">
                                    {{count($cart)}}
                                </span>
                            </button>
                        </a>
                        <a href="{{route('user#historyPage')}}" class="btn px-0 ml-3">
                            <button type="button" class="btn bg-darkblue text-white position-relative">
                                <i class="bi bi-clock-history"></i> History
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">
                                    {{count($history)}}
                                </span>
                            </button>
                        </a>
                        <div class="btn-group ml-3">
                            <button type="button" class="btn bg-success text-white dropdown-toggle" id="accountDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="accountDropdown">
                                <!-- Account Link -->
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-user"></i> Account
                                    </a>
                                </li>
                                <!-- Orders Link -->
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="fas fa-box"></i> My Orders
                                    </a>
                                </li>
                                <!-- Divider -->
                                <li><hr class="dropdown-divider"></li>
                                <!-- Logout Button -->
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit">
                                            <i class="fas fa-sign-out-alt"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row px-xl-5">
        <!-- Shop Sidebar Start -->
        <div class="col-lg-3 col-md-4">
            <div class="bg-light p-4 mb-30">
                <form>
                    <div class="d-flex align-items-center justify-content-between mb-3 bg-dark text-white px-3 py-1">
                        <label class="mt-2" for="price-all">Categories</label>
                        <span class="badge border font-weight-normal">{{ count($categories) }}</span>
                    </div>

                    @foreach ($categories as $category)
                    <div class="d-flex align-items-center justify-content-between mb-3 pt-2">
                        <a href="{{ route('user#filter', $category->id) }}" class="text-dark">
                            <label for="price-1">{{ $category->name }}</label>
                        </a>
                    </div>
                    @endforeach

                </form>
            </div>
        </div>
        <!-- Shop Sidebar End -->

        <!-- Shop Product Start -->
        <div class="col-lg-9 col-md-8">
            <div class="row pb-3">
                <div class="col-12 pb-1">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div>
                            <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                            <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                        </div>

                        <div class="ml-2">
                            <div class="btn-group">
                                <select name="sorting" id="sortingOption" class="form-control">
                                    <option value="">Sorting</option>
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                            <div class="btn-group ml-2">
                                <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Showing</button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#">10</a>
                                    <a class="dropdown-item" href="#">20</a>
                                    <a class="dropdown-item" href="#">30</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" id="dataList">
                    @if (count($products) != 0)
                    @foreach ($products as $product)
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('storage/' . $product->image) }}" style="height: 250px; object-fit:cover;">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href="{{ route('user#detailsPage', $product->id) }}"><i class="bi bi-eye"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="#">{{ $product->name }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ $product->price }} kyats</h5>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <p class="text-center shadow-sm fs-1 col-6 offset-3 py-5">There are no products <i class="fa-brands fa-product-hunt"></i></p>
                    @endif
                </div>
            </div>
        </div>
        <!-- Shop Product End -->
    </div>
</div>

@endsection

@section('scriptSource')
<script>
    $(document).ready(function() {
        $('#sortingOption').change(function() {
            let sortOption = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/user/ajax/product/list',
                data: { 'status': sortOption },
                dataType: 'json',
                success: function(response) {
                    let listHtml = '';
                    response.forEach(product => {
                        listHtml += `
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100 " style="height: 250px;" src="/storage/${product.image}">
                                        <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href="#"><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="bi bi-eye"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="#">${product.name}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>${product.price} kyats</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    $('#dataList').html(listHtml); // Render the product list
                }
            });
        });
    });
</script>
@endsection
