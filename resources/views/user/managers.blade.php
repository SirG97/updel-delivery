@extends('user.layout.access_role')
@section('title', 'Managers')
@section('icon', 'fa-user-plus')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @include('includes\message')
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">

            <div class="custom-panel card py-2">
                <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                    Managers
                </div>
                <div class="table-responsive">
                    <table class="table table-hover ">
                        <thead class="trx-bg-head text-secondary py-3 px-3">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Created </th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="table-style">
                        @if(!empty($staffs) && count($staffs) > 0)
                            @foreach($staffs as $staff)
                                <tr class="">
                                <td scope="row" class="align-middle py-2">
                                    @if($staff['image'] !== '')
                                        <img class="avatar rounded-circle img-thumbnail img-fluid" src="/{{$staff['image']}}" alt="profile pics">
                                    @else
                                        <img class="avatar rounded-circle img-thumbnail img-fluid" src="/img/avatar-1.jpg" alt="profile pics">
                                    @endif
                                </td>
                                    <td class="align-middle">
                                        {{ $staff['firstname'] }} {{ $staff['lastname']  }}
                                    </td>
                                <td class="align-middle">{{ $staff['email'] }}</td>
                                <td class="align-middle">{{ $staff['phone'] }}</td>
                                <td class="align-middle">{{ $staff['created_at']->diffForHumans() }}</td>
                                    <td class="table-action align-middle">
                                        <a href="/manager/{{ $staff['user_id'] }}" ><i class="fas fa-fw fa-eye text-success" title="View order details"></i></a> &nbsp; &nbsp;
                                        <i class="fas fa-fw fa-edit text-primary align-"
                                           data-toggle="modal"
                                           data-target="#editStaffModal"
                                           title="Edit staff details"
                                           data-user_id="{{ $staff['user_id'] }}"
                                           data-firstname="{{ $staff['firstname'] }}"
                                           data-lastname="{{ $staff['lastname'] }}"
                                           data-username="{{ $staff['username'] }}"
                                           data-email="{{ $staff['email'] }}"
                                           data-password=""
                                           data-phone="{{ $staff['phone'] }}"
                                           data-address="{{ $staff['address'] }}"
                                           data-city="{{ $staff['city'] }}"
                                           data-state="{{ $staff['state'] }}"
                                           data-admin_right="{{ $staff['admin_right'] }}"
                                           data-job_title="{{ $staff['job_title'] }}"
                                           data-job_description="{{ $staff['job_description'] }}"
                                        ></i> &nbsp; &nbsp;
                                        <i class="fas fa-fw fa-trash text-danger"
                                           title="Delete staff details"
                                           data-toggle="modal"
                                           data-target="#deleteStaffModal"
                                           data-user_id="{{ $staff['user_id'] }}"></i>
                                    </td>

                            </tr>
                            @endforeach
                            {{-- Edit Modal--}}
                            <div class="modal fade bd-example-modal-lg" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit staff</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="msg" class="d-flex">

                                            </div>
                                            <form id="editStaffForm" enctype="multipart/form-data">
                                                <div class="col-md-12">
                                                    <div class="form-row">
                                                        <input type="hidden" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                                                        <input type="hidden" name="user_id" id="user_id" value="">
                                                        <div class="col-md-4 mb-3">
                                                            <label for="firstname">First name</label>
                                                            <input type="text" class="form-control" id="firstname" name="firstname" value="" required>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="lastname">Last name</label>
                                                            <input type="text" class="form-control" id="lastname" name="lastname" value="" required>

                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="email">Email</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text" id="inputGroupPrepend3">@</span>
                                                                </div>
                                                                <input type="email" class="form-control" name="email" id="email" aria-describedby="inputGroupPrepend3" required>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-5 mb-3">
                                                            <label for="username">Username</label>
                                                            <input type="text" class="form-control"  name="username" id="username" required>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <label for="phone">Phone number</label>
                                                            <input type="text" class="form-control"  name="phone" id="phone" required>

                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="city">City</label>
                                                            <input type="text" class="form-control" name="city" id="city" required>

                                                        </div>


                                                    </div>
                                                    <div class="form-row">
                                                        <div class="col-md-3 mb-3">
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
                                                        <div class="col-md-4 mb-3">
                                                            <label for="amount">Password</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="password" value="" id="password" class="form-control" >
                                                            </div>
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
                                                        <div class="col-md-3 mb-3">
                                                            <label for="address">Address</label>
                                                            <input type="text" class="form-control"  name="address" id="address" required>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="job_title">Job title</label>
                                                            <input type="text" class="form-control"  name="job_title" id="job_title" required>
                                                        </div>
                                                        <div class="col-md-3 mb-3">
                                                            <label for="job_description">Job Description</label>
                                                            <div class="input-group mb-3">
                                                                <input type="text" name="job_description" value="" id="job_description"  class="form-control" >
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="custom-file-label" for="profile_pics">Choose file</label>
                                                            <div class="input-group custom-file">
                                                                <input type="file" name="profile_pics" class="custom-file-input" id="profile_pics">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary" id="editStaffBtn">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Delete Modal--}}
                            <div class="modal fade" id="deleteStaffModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Delete staff</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="staffDeleteForm" action="" method="POST">
                                                <div class="col-md-12">
                                                    Delete staff?
                                                    <input type="hidden" id="token" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-danger" id="deleteStaffBtn">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @else
                            <tr>
                                <td colspan="5">
                                    <div class="d-flex justify-content-center">No Managers yet</div>
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


@endsection