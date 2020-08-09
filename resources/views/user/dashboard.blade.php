@extends('user.layout.access_role')
@section('title', 'Dashboard')
@section('icon', 'fa-tachometer-alt')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card bg-c-blue order-card text-secondary">
                    <div class="card-body">
                        <h6 class="text-primary">Total Orders</h6>
                        <h5 class="text-right">
                            <i class="fas fa-truck  float-left"></i>
                            <span>
                              {{$total_orders}}
                            </span>
                        </h5>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card bg-c-blue order-card text-secondary">
                    <div class="card-body">
                        <h6 class="text-primary">Orders completed</h6>
                        <h5 class="text-right">
                            <i class="fas fa-shipping-fast  float-left"></i>
                            <span>
                                 {{$total_completed}}
                            </span>
                        </h5>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card bg-c-blue order-card text-secondary">
                    <div class="card-body">
                        <h6 class="text-primary">Ongoing orders</h6>
                        <h5 class="text-right">
                            <i class="fas fa-shopping-basket  float-left"></i>
                            <span>
                                {{$total_ongoing}}
                            </span>
                        </h5>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card bg-c-blue order-card text-secondary">
                    <div class="card-body">
                        <h6 class="text-primary">Pot</h6>
                        <h5 class="text-right">
                            <i class="fas fa-trash-restore  float-left"></i>
                            <span>
                                {{$total_pot}}
                            </span>
                        </h5>

                    </div>
                </div>
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
                                @foreach($orders as $o)
                                    @foreach($o->orders as $order)
                                        <tr>
                                            <td scope="row">
                                                @if($order['order_status'] === 'delivered')
                                                    <i class="fas fa-fw fa-check-circle text-success"></i>
                                                @elseif($order['order_status'] === 'ongoing')
                                                    <i class="fas fa-fw fa-shipping-fast text-info"></i>
                                                @elseif($order['order_status'] === 'registered')
                                                    <i class="fas fa-fw fa-registered text-primary"></i>
                                                @elseif($order['order_status'] === 'uncompleted')
                                                    <i class="fas fa-fw fa-times-circle text-danger"></i>
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
        {{--                                           data-district="{{ $order['district'] }}"--}}
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
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7">
                                        <div class="d-flex justify-content-center flex-column align-items-center">
                                            <div class="align-items-center"><i class="fas fa-fw fa-shipping-fast fa-2x"></i></div>
                                            <div>No Orders yet</div>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer py-1 mt-0 mr-3 d-flex justify-content-end">
                        <a href="/orders" class="btn btn-primary btn-sm px-3">View more</a>
                    </div>

                </div>
            </div>

        </div>
    </div>

@endsection