
@extends('user.layout.access_role')
@section('title', 'Profile')
@section('icon', 'fa-user-plus')
@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Profile
                    </div>
                    <form action="/profile/edit" method="POST">
                        <div class="container">
                            <div class="row trx-bg-head py-3">
                                <div class="col-md-8 offset-md-2">
                                    @include('includes\message')
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <div class="profile-img">

                                            </div>
                                        </div>
                                        <div class="col-md-8 mb-3">
                                            <div class="col-md-12 mb-3">
                                                <label for="firstname">First name</label>
                                                <input type="text" class="form-control" id="firstname" name="firstname" value="" required>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="lastname">Last name</label>
                                                <input type="text" class="form-control" id="lastname" name="lastname" value="" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <input type="hidden" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                                        <div class="col-md-4 mb-3">
                                            <label for="email">Email</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend3">@</span>
                                                </div>
                                                <input type="email" class="form-control" name="email" id="email" aria-describedby="inputGroupPrepend3" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control"  name="username" id="username" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="phone">Phone number</label>
                                            <input type="text" class="form-control"  name="phone" id="phone" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-3 mb-3">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" name="city" id="city" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="state">State</label>
                                            <select class="custom-select" id="state" name="state" required>
                                                <option selected value="Anambra">Anambra</option>
                                                <option value="Delta">Delta</option>
                                                <option value="Enugu">Enugu</option>
                                                <option value="Ebonyi">Ebonyi</option>
                                                <option value="Imo">Imo</option>
                                                <option value="Abia">Abia</option>
                                            </select>
                                        </div>
                                        <div class="col-md-5 mb-3">
                                            <label for="admin_right">Priviledge</label>
                                            <select class="custom-select" id="admin_right" name="admin_right" required>
                                                <option selected value="Admin">Admin</option>
                                                <option value="Manager">Manager</option>
                                                <option value="Customer Service Adviser">Customer Service Adviser</option>
                                                <option value="Rider">Rider</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-5 mb-3">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control"  name="address" id="address" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="job_title">Job title</label>
                                            <input type="text" class="form-control"  name="job_title" id="job_title" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="job_description">Job Description</label>
                                            <div class="input-group mb-3">
                                                <input type="text" name="job_description" value="" id="job_description"  class="form-control" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer py-2 mt-2 mr-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-sm px-3">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
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
