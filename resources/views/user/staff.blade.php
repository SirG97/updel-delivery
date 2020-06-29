
@extends('user.layout.access_role')
@section('title', 'Staff Detail')
@section('icon', 'fa-user-plus')
@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Profile
                    </div>
                        <div class="container">
                            <div class="row trx-bg-head py-3">
                                <div class="col-md-8 offset-md-2">
                                    @include('includes\message')

                                    @if(!empty($profile))

                                        <div class="col-md-12 mb-3 d-flex align-items-center flex-column justify-content-center" style="height: inherit">
                                            <div class="profile-img my-auto">
                                                <img class=" rounded-circle img-thumbnail img-fluid" src="/{{$profile->image}}" alt="profile pics">
                                            </div>
                                        </div>
                                        <div class="basic-section">
                                            <h3 class="text-center">{{$profile->firstname}} {{$profile->lastname}}</h3>
                                            <h6 class="text-center text-primary">{{$profile->admin_right}}</h6>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="card  order-card text-secondary">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            <h6 class="text-secondary">Job title:</h6>
                                                            <p>{{$profile->job_title}}</p>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <h6 class="text-secondary">Job description:</h6>
                                                            <p>{{$profile->job_description}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <h6 class="text-secondary">Email:</h6>
                                                            <p>{{$profile->email}}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <h6 class="text-secondary">Username:</h6>
                                                            <p>{{$profile->username}}</p>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <h6 class="text-secondary">Phone:</h6>
                                                            <p>{{$profile->phone}}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <h6 class="text-secondary">City:</h6>
                                                            <p>{{$profile->city}}</p>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <h6 class="text-secondary">State:</h6>
                                                            <p>{{$profile->state}}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="text-secondary">Address:</h6>
                                                            <p>{{$profile->address}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                </div>
            </div>

        </div>
    </div>
@endsection()
