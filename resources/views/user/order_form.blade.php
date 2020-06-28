@extends('user.layout.access_role')
@section('title', 'New Order')
@section('icon', 'fa-shipping-fast')
@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Create new order
                    </div>
                    <form action="/save_order" method="POST">
                        <div class="container">
                            <div class="row cool-border trx-bg-head py-3">
                                <div class="col-md-10 offset-md-1">
                                    @include('includes\message')
                                    <div class="form-row">
                                        <input type="hidden" id="token" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                                        <div class="col-md-3 mb-3">
                                            <label for="amount">Request Type</label>
                                            <select class="custom-select" id="request_type" name="request_type" onchange="input_to_disable()" required>
                                                <option value="combo">Combo Request</option>
                                                <option value="collection">Collection Request</option>
                                                <option value="delivery">Delivery Request</option>
                                                <option value="swap">Swap Request</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="amount">Sub services</label>
                                            <select class="custom-select" id="request_type" name="request_type" onchange="input_to_disable()" required>
                                                <option value="same-day">Same day delivery</option>
                                                <option value="next-day">Next day delivery</option>
                                                <option value="two-day">Two day delivery</option>
                                                <option value="premium">Premium service</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mb-3">
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
                                        <div class="col-md-3 mb-3">
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
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="fullname">Customer name</label>
                                            <input type="text" class="form-control" id="fullname" name="fullname" value="" required>

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" value="" required>

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="phone">Phone number</label>
                                            <input type="text" class="form-control"  name="phone" id="phone" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-5 mb-3">
                                            <label for="parcel_name">Parcel name</label>
                                            <input type="text" class="form-control"  name="parcel_name" id="parcel_name" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="parcel_size">Parcel size</label>
                                            <input type="text" class="form-control" name="parcel_size" id="parcel_size" required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="parcel_quantity">Quantity</label>
                                            <input type="number" min="1" value="1" class="form-control" name="parcel_quantity" id="parcel_quantity" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-4 mb-3">
                                            <label for="pick_up_address">Pickup address</label>
                                            <input type="text" class="form-control" name="pick_up_address" id="pick_up_address" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="pick_up_landmark">Pickup landmark</label>
                                            <input type="text" class="form-control" name="pick_up_landmark" id="pick_up_landmark" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="delivery_address">Delivery address</label>
                                            <input type="text" class="form-control"  name="delivery_address" id="delivery_address" required>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6 mb-3">
                                            <label for="delivery_landmark">Delivery landmark</label>
                                            <input type="text" class="form-control"  name="delivery_landmark" id="delivery_landmark" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="description">Description</label>
                                            <div class="input-group mb-3">
                                                <input type="text" name="description" value="" id="description"  class="form-control" >
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
    </div>
@endsection()
