@extends('user.layout.access_role')
@section('title', 'Pot')
@section('icon', 'fa-trash-restore')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-6">
                <div class="searchbox mt-0 mr-0">
                    <div class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="text" class="form-control" id="search" placeholder="Search Port" style="border:0;">
                    </div>
                    <div class="search-result">
                        <ul class="list-group list-group-flush" id="search-result-list">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('includes\message')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Orders
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead class="trx-bg-head text-secondary py-3 px-3">
                            <tr>
                                <th scope="col">Status</th>
                                <th scope="col">Order ID</th>
                                <th scope="col">Parcel name</th>
                                <th scope="col">Owner</th>
                                <th scope="col">Request Type</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-style">

                            @if(!empty($orders) && count($orders) > 0)
                                @foreach($orders as $order)<tr>
                                    <td scope="row">
                                        @if($order['order_status'] === 'delivered' || $order['order_status'] === 'completed')
                                            <i class="fas fa-fw fa-check-circle text-success"></i>
                                        @elseif($order['order_status'] === 'ongoing')
                                            <i class="fas fa-fw fa-shipping-fast text-info"></i>
                                        @elseif($order['order_status'] === 'registered')
                                            <i class="fas fa-fw fa-registered text-primary"></i>
                                        @elseif($order['order_status'] === 'abandoned')
                                            <i class="fas fa-fw fa-times-circle text-danger"></i>
                                        @elseif($order['order_status'] === 'uncompleted')
                                            <i class="fas fa-fw fa-info-circle text-danger"></i>
                                        @endif
                                    </td>
                                    <td>{{ $order['order_no'] }}</td>
                                    <td>{{ $order['parcel_name'] }}</td>
                                    <td>{{ $order['fullname'] }}</td>
                                    <td>{{ $order['request_type'] }}</td>
                                    <td>{{ $order['phone'] }}</td>
                                    <td class="table-action d-flex flex-nowrap">
                                        <a href="/order/{{ $order['order_no'] }}" ><i class="fas fa-fw fa-eye text-success" title="View order details"></i></a> &nbsp; &nbsp;
                                        <i class="fas fa-fw fa-edit text-primary"
                                           data-toggle="modal"
                                           data-target="#editOrderModal"
                                           title="Edit order details"
                                           data-order_no="{{ $order['order_no'] }}"
                                           data-request_type="{{ $order['request_type'] }}"
                                           data-district="{{ $order['district'] }}"
                                           data-route="{{ $order['route'] }}"
                                           data-fullname="{{ $order['fullname'] }}"
                                           data-email="{{ $order['email'] }}"
                                           data-service_type="{{ $order['service_type'] }}"
                                           data-address="{{ $order['address'] }}"
                                           data-phone="{{ $order['phone'] }}"
                                           data-parcel_name="{{ $order['parcel_name'] }}"
                                           data-parcel_size="{{ $order['parcel_size'] }}"
                                           data-pick_up_address="{{ $order['pick_up_address'] }}"
                                           data-pick_up_landmark="{{ $order['pick_up_landmark'] }}"
                                           data-delivery_address="{{ $order['delivery_address'] }}"
                                           data-delivery_landmark="{{ $order['delivery_landmark'] }}"
                                           data-description="{{ $order['description'] }}"
                                        ></i> &nbsp; &nbsp;
                                        <i class="fas fa-fw fa-trash text-danger"
                                           title="Delete order details"
                                           data-toggle="modal"
                                           data-target="#deleteOrderModal"
                                           data-order_no="{{ $order['order_no'] }}"></i>
                                    </td>

                                </tr>
                                @endforeach
                                {{-- Edit Modal--}}
                                <div class="modal fade bd-example-modal-lg" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Edit order</h5>
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
                                                            <input type="hidden" id="token" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                                                            <input type="hidden" id="order_no" name="order_no" value="">
                                                            <div class="col-md-3 mb-3">
                                                                <label for="amount">Request Type</label>
                                                                <select class="custom-select" id="request_type" name="request_type" onchange="input_to_disable()" required>
                                                                    <option value="combo">Combo Request</option>
                                                                    <option value="collection">Collection Request</option>
                                                                    <option value="delivery">Delivery Request</option>
                                                                    <option value="swap">Swap Request</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-5 mb-3">
                                                                <label for="service_type">Sub services</label>
                                                                <select class="custom-select" id="service_type" name="service_type" required>
                                                                    <option value="same-day">Same day delivery</option>
                                                                    <option value="next-day">Next day delivery</option>
                                                                    <option value="two-day">Two day delivery</option>
                                                                    <option value="premium">Premium service</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="amount">Select district</label>
                                                                <select class="custom-select" name="district" id="district" required>
                                                                    @if(!empty($districts) && count($districts) > 0)
                                                                        <option value="" selected>Select a district</option>
                                                                        @foreach($districts as $district)
                                                                            <option value={{$district->name}}> {{$district->name}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="" disabled selected>Create a district first</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-md-4 mb-3">
                                                                <label for="admin_right">Select route</label>
                                                                <select class="custom-select" id="route" name="route" required>
                                                                    @if(!empty($routes) && count($routes) > 0)
                                                                        <option value="" selected>Select a route</option>
                                                                        @foreach($routes as $route)
                                                                            <option value={{$route->name}}> {{$route->name}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        <option value="" disabled selected>Create a route first</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            <div class="col-md-5 mb-3">
                                                                <label for="fullname">Customer name</label>
                                                                <input type="text" class="form-control" id="fullname" name="fullname" value="" required>
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label for="email">Email</label>
                                                                <input type="text" class="form-control" id="email" name="email" value="" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-md-4 mb-3">
                                                                <label for="address">Address</label>
                                                                <input type="text" class="form-control" id="address" name="address" value="" required>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="phone">Phone number</label>
                                                                <input type="text" class="form-control"  name="phone" id="phone" required>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label for="parcel_name">Parcel name</label>
                                                                <input type="text" class="form-control"  name="parcel_name" id="parcel_name" required>
                                                            </div>


                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-md-3 mb-3">
                                                                <label for="parcel_size">Parcel size</label>
                                                                <input type="text" class="form-control" name="parcel_size" id="parcel_size" required>
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label for="parcel_quantity">Quantity</label>
                                                                <input type="number" min="1" value="1" class="form-control" name="parcel_quantity" id="parcel_quantity" required>
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label for="pick_up_address">Pickup address</label>
                                                                <input type="text" class="form-control" name="pick_up_address" id="pick_up_address" required>
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label for="pick_up_landmark">Pickup landmark</label>
                                                                <input type="text" class="form-control" name="pick_up_landmark" id="pick_up_landmark" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col-md-4 mb-3">
                                                                <label for="delivery_address">Delivery address</label>
                                                                <input type="text" class="form-control"  name="delivery_address" id="delivery_address" required>
                                                            </div>
                                                            <div class="col-md-3 mb-3">
                                                                <label for="delivery_landmark">Delivery landmark</label>
                                                                <input type="text" class="form-control"  name="delivery_landmark" id="delivery_landmark" required>
                                                            </div>
                                                            <div class="col-md-5 mb-3">
                                                                <label for="description">Description</label>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" name="description" value="" id="description"  class="form-control" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="editOrderBtn">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Delete Modal--}}
                                <div class="modal fade" id="deleteOrderModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete order</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="orderDeleteForm" action="" method="POST">
                                                    <div class="col-md-12">
                                                        Delete order?
                                                        <input type="hidden" id="token" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-danger" id="deleteOrderBtn">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex justify-content-center">No problem with any delivery</div>
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