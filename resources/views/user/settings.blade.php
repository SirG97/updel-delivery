@extends('user.layout.access_role')
@section('title', 'Settings')
@section('icon', 'fa-cogs')
@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Password settings
                    </div>
                    <div class="container">
                        <div class="row trx-bg-head py-3" style="border-top: 1px solid #e3e8ee; border-bottom: 1px solid #e3e8ee">
                            <div class="col-md-4 offset-md-3">
                                <div class="form-group">
                                    <label for="oldpassword" class="">Old Password</label>
                                    <input type="password" class="form-control" value="" id="oldpassword" name="oldpassword">
                                </div>
                                <div class="form-group">
                                    <label for="password" class="">Password</label>
                                    <input type="password" class="form-control" value="" id="password" name="password">
                                </div>
                                <div class="form-group">
                                    <label for="cpassword" class="">Confirm Password</label>
                                    <input type="password" class="form-control" value="" id="cpassword" name="cpassword">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer py-2 mt-2 mr-3 d-flex justify-content-end">
                        <div class="btn btn-primary btn-sm px-3">Save</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection()