@extends('layouts.master')
@section('content')
<div class="login-form">
    <form action="{{route('login')}}" method="post">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input class="form-control" id="email" type="email" name="email" placeholder="Email">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input class="form-control" id="password" type="password" name="password" placeholder="Password">
        </div>

        <button class="btn btn-success w-100 mb-3" type="submit">Log In</button>

    </form>
    <div class="register-link">
        <p>
            Don't you have an account?
            <a href="{{route('auth#registerPage')}}">Sign Up Here</a>
        </p>
    </div>
</div>
@endsection
