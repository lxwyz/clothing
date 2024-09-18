@extends('user.layouts.master')

@section('content')

<!-- MAIN CONTENT-->
<div class="main-content">
    <div class="section__content section__content--p30">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title text-center">
                                <h3 class="title-2">Account Profile</h3>
                            </div>
                            <hr>
                            @if(session('updateSuccess'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-lg"></i>{{ session('updateSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <form action="{{ route('user#accountChange', Auth::user()->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Profile Picture -->
                                    <div class="col-md-4 d-flex flex-column align-items-center">
                                        @if (Auth::user()->image)
                                            <img src="{{ asset('storage/' . Auth::user()->image) }}" class="img-thumbnail shadow-sm profile-image" />
                                        @else
                                            <img src="{{ Auth::user()->gender == 'female' ? asset('image/placeholder-female.jpg') : asset('image/default_user3.png') }}" class="img-thumbnail shadow-sm profile-image" />
                                        @endif
                                        <div class="mt-3">
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                        <div class="mt-2">
                                            <button type="submit" class="btn btn-danger">
                                                <i class="zmdi zmdi-upload"></i> Update
                                            </button>
                                        </div>
                                    </div>
                                    <!-- Form Fields -->
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label class="control-label mb-1">Name</label>
                                            <input name="name" type="text" value="{{ old('name', Auth::user()->name) }}" class="form-control" placeholder="Enter Your Name">
                                            @error('name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label mb-1">Email</label>
                                            <input name="email" type="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" placeholder="Enter Your Email">
                                            @error('email')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label mb-1">Address</label>
                                            <textarea name="address" class="form-control" rows="4" placeholder="Enter Your Address">{{ old('address', Auth::user()->address) }}</textarea>
                                            @error('address')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="Gender">Gender</label>
                                            <select name="gender" class="form-control">
                                                <option value="" disabled>Select Gender</option>
                                                <option value="male" {{ old('gender', Auth::user()->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                                <option value="female" {{ old('gender', Auth::user()->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                            @error('gender')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label mb-1">Phone</label>
                                            <input name="phone" type="text" class="form-control" value="{{ old('phone', Auth::user()->phone) }}" placeholder="Enter Your Phone">
                                            @error('phone')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label mb-1">Role</label>
                                            <input name="role" type="text" class="form-control" value="{{ old('role', Auth::user()->role) }}" disabled>
                                        </div>
                                        <div class="text-center">
                                            <a href="{{ route('admin#details') }}" class="btn btn-secondary">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<!-- Additional CSS -->
<style>
    .profile-image {
        width: 150px; /* Set the desired width */
        height: auto; /* Maintain aspect ratio */
        border-radius: 50%; /* Optional: To make the image round */
    }
    .img-thumbnail {
        max-width: 100%;
        height: auto;
    }
</style>
