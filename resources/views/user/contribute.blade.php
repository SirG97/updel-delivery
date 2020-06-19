@extends('user.layout.base')
@section('title', 'Generate Pins')
@section('icon', 'fa-user-plus')
@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12 d-flex justify-content-center">
                <div class=" flex-column">
                    <div class="login-box">
                        @include('includes/message')
                        <form action="/contribute" method="POST" id="form">

                            <input type="hidden" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                            <div class="form-group">
                                <label for="email" class="font-weight-bold">Number</label>
                                <input type="text" class="form-control form-control-lg" value="09087675432" id="phone" name="phone">
                            </div>
                            <div class="form-group">
                                <label for="password" class="font-weight-bold">Pin</label>
                                <input type="text" class="form-control form-control-lg" value="" id="password" name="pin">
                            </div>
                            <button class="btn btn-primary btn-block btn-lg" type="submit">Contribute</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection()