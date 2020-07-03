@extends('user.layout.access_role')
@section('title', 'Authorization')
@section('icon', 'fa-shield-alt')
@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Authorization QR code
                    </div>
                        <div class="container">
                            <div class="row cool-border trx-bg-head py-3">
                                <div class="col-md-8 offset-md-2">
                                    @include('includes\message')
                                    <div class="qrcode-container text-center">
                                        @if($qr_code !== '' and $qr_code !== null)
                                            <img src="/{{$qr_code->auth_img}}" class="img-fluid" alt="QR_code authorizer">
                                        @else
                                            <i class="fas fa-fw fa-qrcode fa-2x"></i>
                                            No barcode generated yet
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    <form action="/generate_qr_code" method="POST">
                        <input type="hidden" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                        <input type="hidden" name="user_id" value="{{\App\Classes\Session::get('SESSION_USER_ID')}}">
                        <div class="panel-footer py-2 mt-2 mr-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-sm px-3">Generate QRcode</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection()

