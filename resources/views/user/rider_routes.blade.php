
@extends('user.layout.access_role')
@section('title', 'Profile')
@section('icon', 'fa-user-plus')
@section('content')
    <div class="container-fluid">
        @include('includes\message')
        <div class="row">
            <div class="col-md-5">
                <div class="custom-panel card py-sm-3 py-2 px-2 px-sm-3">
                    @if(!empty($profile))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12 mb-3 d-flex align-items-center flex-column justify-content-center" style="height: inherit">
                                    <div class="profile-img my-auto">
                                        <img class=" rounded-circle img-thumbnail img-fluid" src="/{{$profile->image}}" alt="profile pics">
                                    </div>
                                </div>
                                <div class="basic-section">
                                    <h3 class="text-center">{{$profile->firstname}} {{$profile->lastname}}</h3>
                                    <h6 class="text-center text-primary">{{$profile->admin_right}}</h6>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-7">
                <div class="custom-panel card py-sm-3 py-2 px-2 px-sm-3">
                    <div class="d-flex flex-column">
                        <i class="far fa-fw fa-building fa-3x align-self-center icon-color"></i>
                        <h6 class="text-center">Assigned District</h6>
                        <div class="table-responsive">
                            <table class="table table-hover ">
                                <thead class="trx-bg-head text-secondary py-3 px-3">
                                <tr>
                                    <th scope="col">District</th>
                                    <th scope="col">Assigned by</th>
                                    <th scope="col">Role</th>
                                    <th scope="col" class="d-flex justify-content-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody class="table-style">

                                @if(!empty($assigned_districts) && count($assigned_districts) > 0)
                                    @foreach($assigned_districts as $assigned_district)
                                        @foreach($assigned_district->districts as $district)
                                            <tr>
                                                <td scope="row">{{ $district['name'] }}</td>
                                                <td scope="row">{{ $assigned_district['assigned_by'] }}</td>
                                                <td scope="row">{{ $assigned_district['assignee_status'] }}</td>
                                                <td class="table-action d-flex justify-content-center">
                                                &nbsp; &nbsp
                                                    <i class="fas fa-fw fa-trash text-danger"
                                                       title="Delete assigned route"
                                                       data-toggle="modal"
                                                       data-target="#deleteAssignedRouteModal"
                                                       data-rider_id="{{ $assigned_district['rider_id'] }}"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach

                                    {{-- Delete Modal--}}
                                    <div class="modal fade" id="deleteAssignedRouteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Delete district</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="assignedRouteDeleteForm" action="" method="POST">
                                                        <div class="col-md-12">
                                                            Delete assigned district?
                                                            <input type="hidden" id="token" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-danger" id="deleteAssignedRouteBtn">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <tr>
                                        <td colspan="7">
                                            <div class="d-flex justify-content-center">No district assigned</div>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="custom-panel card py-sm-3 py-2 px-2 px-sm-3">
                    <div class="d-flex flex-column">
                        <form class="mt-3" action="/route/assign" method="POST">
                            <input type="hidden" id="token" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                            <input type="hidden" id="user_id" name="user_id" value="{{$profile->user_id}}">
                            <label for="district_to_assign" class="">Select a district to assign</label>
                            <select class="custom-select" name="district_to_assign" id="district_to_assign" required>
                                @if(!empty($districts) && count($districts) > 0)
                                    <option value="" selected>Select a district</option>
                                    @foreach($districts as $district)
                                        <option value={{$district['district_id']}}> {{$district['name']}}</option>
                                    @endforeach
                                @else
                                    <option value="" disabled selected>No district available to assign</option>
                                @endif
                            </select>
                            <div class="panel-footer py-2 mt-2  d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary btn-sm px-3">Assign</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
{{--        <div class="row ">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="custom-panel card py-2">--}}
{{--                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">--}}
{{--                        Rider routes--}}
{{--                    </div>--}}
{{--                        <div class="container">--}}
{{--                            <div class="row trx-bg-head py-3">--}}
{{--                                <div class="col-md-10 offset-md-1">--}}
{{--                                    @include('includes\message')--}}

{{--                                    @if(!empty($profile))--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col-md-6">--}}
{{--                                                <div class="col-md-12 mb-3 d-flex align-items-center flex-column justify-content-center" style="height: inherit">--}}
{{--                                                    <div class="profile-img my-auto">--}}
{{--                                                        <img class=" rounded-circle img-thumbnail img-fluid" src="/{{$profile->image}}" alt="profile pics">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div class="basic-section">--}}
{{--                                                    <h3 class="text-center">{{$profile->firstname}} {{$profile->lastname}}</h3>--}}
{{--                                                    <h6 class="text-center text-primary">{{$profile->admin_right}}</h6>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col-md-6">--}}
{{--                                                <div class="col-md-12">--}}
{{--                                                    <div class="card  order-card text-secondary">--}}
{{--                                                        <div class="card-body">--}}
{{--                                                            <div class="row">--}}
{{--                                                                <div class="col-md-5">--}}
{{--                                                                    <h6 class="text-secondary">Job title:</h6>--}}
{{--                                                                    <p>{{$profile->job_title}}</p>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-7">--}}
{{--                                                                    <h6 class="text-secondary">Job description:</h6>--}}
{{--                                                                    <p>{{$profile->job_description}}</p>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="row">--}}
{{--                                                                <div class="col-md-4">--}}
{{--                                                                    <h6 class="text-secondary">Email:</h6>--}}
{{--                                                                    <p>{{$profile->email}}</p>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4">--}}
{{--                                                                    <h6 class="text-secondary">Username:</h6>--}}
{{--                                                                    <p>{{$profile->username}}</p>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-4">--}}
{{--                                                                    <h6 class="text-secondary">Phone:</h6>--}}
{{--                                                                    <p>{{$profile->phone}}</p>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="row">--}}
{{--                                                                <div class="col-md-3">--}}
{{--                                                                    <h6 class="text-secondary">City:</h6>--}}
{{--                                                                    <p>{{$profile->city}}</p>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-3">--}}
{{--                                                                    <h6 class="text-secondary">State:</h6>--}}
{{--                                                                    <p>{{$profile->state}}</p>--}}
{{--                                                                </div>--}}
{{--                                                                <div class="col-md-6">--}}
{{--                                                                    <h6 class="text-secondary">Address:</h6>--}}
{{--                                                                    <p>{{$profile->address}}</p>--}}
{{--                                                                </div>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}


{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--        <div class="row ">--}}
{{--            <div class="col-md-12">--}}
{{--                <div class="custom-panel card py-2">--}}
{{--                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">--}}
{{--                        Password settings--}}
{{--                    </div>--}}
{{--                    <div class="container">--}}
{{--                        <div class="row trx-bg-head py-3" style="border-top: 1px solid #e3e8ee; border-bottom: 1px solid #e3e8ee">--}}
{{--                            <div class="col-md-4 offset-md-3">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="oldpassword" class="">Old Password</label>--}}
{{--                                    <input type="password" class="form-control" value="" id="oldpassword" name="oldpassword">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="password" class="">Password</label>--}}
{{--                                    <input type="password" class="form-control" value="" id="password" name="password">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="cpassword" class="">Confirm Password</label>--}}
{{--                                    <input type="password" class="form-control" value="" id="cpassword" name="cpassword">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="panel-footer py-2 mt-2 mr-3 d-flex justify-content-end">--}}
{{--                        <div class="btn btn-primary btn-sm px-3">Save</div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
    </div>
@endsection()
