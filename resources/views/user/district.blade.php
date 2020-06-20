@extends('user.layout.access_role')
@section('title', 'District')
@section('icon', 'fa-building')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @include('includes\message')
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="custom-panel card py-sm-3 py-2 px-2 px-sm-3">
                    <form action="/district/create" method="POST">
                        <div class="d-flex flex-column">
                            <i class="far fa-fw fa-building fa-3x align-self-center icon-color"></i>
                            <h6 class="text-center">Add a new district</h6>
                            <div class="input-group my-3">
                                <input type="hidden" id="token" name="token" value="{{\App\Classes\CSRFToken::_token()}}">

                                <input type="text" class="form-control" placeholder="Eg. Maitama, Surulere" name="name">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">Create</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="custom-panel card py-sm-3 py-2 px-2 px-sm-3">
                    <div class="d-flex flex-column">
                        <i class="far fa-fw fa-paper-plane fa-3x align-self-center icon-color"></i>
                        <h6 class="text-center">Add a new route</h6>
                        <form class="mt-3" action="/route/create" method="POST">
                            <input type="hidden" id="token" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                            <div class="form-group">
                                <select class="custom-select" name="district" required>
                                    @if(!empty($districts) && count($districts) > 0)
                                        <option value="" selected>Select a district</option>
                                        @foreach($districts as $district)
                                            <option value={{$district->district_id}}> {{$district->name}}</option>
                                        @endforeach
                                    @else
                                        <option value="" disabled selected>Create a district first</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="input-group my-3">
                                    <input type="text" class="form-control" name="name" placeholder="Eg. Awolowo drive">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">Create</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Routes
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead class="trx-bg-head text-secondary py-3 px-3">
                            <tr>
                                <th scope="col">Route name</th>
                                <th scope="col">District</th>
                                <th scope="col">Created by</th>
                                <th scope="col">Time</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-style">

                            @if(!empty($routes) && count($routes) > 0)
                                @foreach($routes as $route)<tr>
                                    <td scope="row">{{$route['name']}}</td>
                                    <td>{{ $route['district'] }}</td>
                                    <td>{{ $route['created_by'] }}</td>
                                    <td>{{ $route['created_at']->diffForHumans() }}</td>

                                    <td class="table-action d-flex flex-nowrap">
        {{--                            <a href="/customer/{{ $route['route_id'] }}" >
                                            <i class="fas fa-fw fa-eye text-success" title="View customer details"></i>
                                        </a> &nbsp; &nbsp;--}}
                                        <i class="fas fa-fw fa-edit text-primary"
                                           data-toggle="modal"
                                           data-target="#editModal"
                                           title="Edit route details"
                                           data-name="{{ $route['name'] }}"
                                           data-route_id="{{ $route['route_id'] }}"
                                           data-district="{{ $route['district'] }}"
                                           data-district_id="{{ $route['district_id'] }}"
                                        ></i> &nbsp; &nbsp;
                                        <i class="fas fa-fw fa-trash text-danger"
                                           title="Delete customer details"
                                           data-toggle="modal"
                                           data-target="#deleteModal"
                                           data-route_id="{{ $route['route_id'] }}"></i>
                                    </td>

                                </tr>
                                @endforeach
                                {{-- Edit Modal--}}
                                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit route</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="msg" class="d-flex">

                                                </div>
                                                <form>
                                                    <div class="col-md-12">
                                                        <div class="form-row">
                                                            <input type="hidden" id="route_id"  value="" required>
                                                            <input type="hidden" id="district_id"  value="" required>
                                                            <input type="hidden" id="token" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="district">District</label>
                                                                <select class="custom-select" name="district" id="district" required>
-
                                                                    @if(!empty($districts) && count($districts) > 0)
                                                                        @foreach($districts as $district)
                                                                            <option value={{$district->name}}> {{$district->name}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>

                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="surname">Route name</label>
                                                                <input type="text" class="form-control" id="name" name="name" value="" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="editBtn">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Delete Modal--}}
                                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete route</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="routeDeleteForm" action="" method="POST">
                                                    <div class="col-md-12">
                                                        Delete route?
                                                        <input type="hidden" id="token" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-danger" id="deleteRouteBtn">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex justify-content-center">No routes created</div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer py-1 mt-0 mr-3 d-flex justify-content-end">
                        {!! $links !!}
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection()