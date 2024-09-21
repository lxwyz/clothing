@extends('admin.layouts.app')

@section('title','Admin List')

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
                                @if (Auth::user()->gender == 'female')
                                    @if ($admin->gender == 'male')
                                    <img src="{{ asset('image/default_user3' ) }}" class="img-thumbnail shadow-sm">
                                    @else
                                        <img src="{{asset('image/placeholder-female.jpg')}}" class="img-thumbnail shadow-sm">
                                    @endif
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
                                            <i class="zmdi zmdi-account"></i> Account</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="{{ route('admin#details') }}">
                                            <i class="zmdi zmdi-accounts"></i> Admin List</a>
                                    </div>
                                </div>
                                <div class="account-dropdown__body">
                                    <div class="account-dropdown__item">
                                        <a href="{{ route('admin#changePasswordPage') }}">
                                            <i class="bi bi-key"></i> Change Password</a>
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
                            <h2 class="title-1">Admin List</h2>
                        </div>
                    </div>
                    <div class="table-data__tool-right">

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
                        <form action="{{ route('admin#list') }}" method="GET">
                            @csrf
                            <div class="d-flex">
                                <input type="text" name="key" class="form-control" placeholder="Search..." value="{{ request('key') }}">
                                <button class="btn btn-dark text-white" type="submit">
                                    <i class="bi bi-search-heart-fill"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Admin Name</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Created Date</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody id="dataList">
                            @foreach ($users as $user)
                            <tr class="tr-shadow my-2">
                                <td class="col-1">
                                    @if ($user->image == null)
                                       @if ($user->gender == 'male')
                                            <img src="{{ asset('image/default_user3.png' ) }}" class=" shadow-sm">
                                       @else
                                           <img src="{{asset('image/placeholder-female.jpg')}}" class=" shadow-sm">
                                       @endif
                                    @else
                                        <img src="{{ asset('storage/'.$user->image) }}" class=" shadow-sm">
                                    @endif
                                </td>
                                <input type="hidden" class="userId" value="{{$user->id}}">
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->gender }}</td>
                                <td>{{ $user->created_at->format('j-F-y') }}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->address}}</td>
                                <td>
                                    <select class="form-control statusChange">
                                        <option value="user" @if ($user->role == 'user') selected @endif>User</option>
                                        <option value="admin" @if ($user->role == 'admin') selected @endif>Admin</option>
                                    </select>
                                </td>
                                {{-- <td>
                                    <div class="table-data-feature">
                                        @if(Auth::user()->id== $user->id)

                                        @else
                                        <a href="{{ route('admin#changeRole',$user->id) }}"> <!--- can't delete ur own account but u can delete the other accounts -->
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Role" style="margin-right: 10px;">
                                                <i class="bi bi-box"></i>
                                            </button>
                                        </a>
                                        <a href="{{ route('admin#delete',$user->id) }}"> <!--- can't delete ur own account but u can delete the other accounts -->
                                            <button class="item" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </a>
                                        @endif
                                    </div>
                                </td> --}}
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <br>
                    <div>
                        {{-- <a href="{{route('products#list')}}">
                            <button>
                                <i class="fas fa-backward"></i> Back
                            </button>
                        </a> --}}
                    </div>

                    <!-- Pagination Links -->
                    <div class="mt-3">
                        {{ $users->links() }}
                    </div>
                </div>

                @if($users->isEmpty())
                    <h1 style="color: red;" class="text-center mt-5">THERE ARE NO CUSTOMERS HERE!!</h1>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scriptSource')
x<script>
    $(document).on('change', '.statusChange', function() {
        $currentStatus = $(this).val();
        $parentNode = $(this).parents("tr");
        $userId = $parentNode.find('.userId').val();

        $.ajax({
            type: 'get',
            url: "{{route('admin#ajaxUserChangeStatus')}}",
            data: {
                'role': $currentStatus, // <-- Added the comma here
                'userId': $userId,
            },
            dataType: 'json',
            success: function(response) {
                // If the status is changed to "admin", remove the user from the list
                if ($currentStatus === 'admin') {
                    $parentNode.remove();
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
            }
            location.reload();
        });
    });
</script>
@endsection

