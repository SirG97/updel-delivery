@extends('user.layout.auth')
@section('title', 'Login')
@section('content')
    <form action="/login" method="POST" id="form">
        <div class="formheadercontainer">
            <span class="formheadertext">Sign in to your account</span>
        </div>
        <input type="hidden" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
        <div class="form-group">
            <label for="email" class="font-weight-bold">Email</label>
            <input type="email" class="form-control form-control-lg" value="" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="password" class="font-weight-bold">Password</label>
            <input type="password" class="form-control form-control-lg" value="" id="password" name="password">
        </div>
        <div class="fpassword">
            <a href="/passwordreset">Forgot your password?</a>
        </div>
        <button class="btn btn-primary btn-block btn-lg" type="submit">Login</button>
        <div class="loginregtext">
            <a href="/register">Don't have an account? Register</a>
        </div>
    </form>
@endsection()
