@extends('user.layout.auth')
@section('title', 'Register')
@section('content')

    <form action="/register" method="POST" id="form">
        <div class="formheadercontainer">
            <span class="formheadertext">Create your account</span>
        </div>
        <input type="hidden" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
        <div class="form-group">
            <label for="email" class="font-weight-bold">Email</label>
            <input type="email" class="form-control" value="" id="email" name="email">
        </div>
        <div class="form-row mb-2">
            <div class="col">
                <label for="phone" class="font-weight-bold">First name</label>
                <input type="text" class="form-control" value="" id="firstname" name="firstname">
            </div>
            <div class="col">
                <label for="surname" class="font-weight-bold">Surname</label>
                <input type="text" class="form-control" value="" id="surname" name="surname">
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="font-weight-bold">Password</label>
            <input type="password" class="form-control" value="" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="cpassword" class="font-weight-bold">Confirm Password</label>
            <input type="password" class="form-control" value="" id="cpassword" name="cpassword">
        </div>
        <button class="btn btn-primary btn-block btn-lg" type="submit">Register</button>
        <div class="loginregtext">
            <a href="/login">Already have an account? Login</a>
        </div>
    </form>
@endsection()