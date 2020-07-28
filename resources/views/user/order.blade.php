@extends('user.layout.access_role')
@section('title', 'Order')
@section('icon', 'fa-user-plus')
@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="custom-panel card ">
                    <div class="d-flex justify-content-between py-2 px-3">
                        <div class="text-secondary mb-1">
                            <div class="">{{$order->request_type}} Request</div>
                            <div class="order-name">{{$order->parcel_name}}<span><i class="fas fa-fw fa-check-circle text-success"></i></span></div>

                        </div>
                        <div class="font-weight-bold text-secondary mb-1 d-flex justify-content-end">
                            <div class="text-right">
                                Order ID: {{$order->order_no}}
                            </div>

                        </div>
                    </div>
                    <div class="order-details-container cool-border-top">
                        <div class="order-details d-flex flex-column flex-sm-row py-3">
                            <div class="order-detail px-2">
                                <div class="order-detail-title mt-1">Name</div>
                                <div>{{$order->fullname}}</div>
                            </div>
                            <div class="order-detail px-2">
                                <div class="order-detail-title mt-1">Address:</div>
                                <div>{{$order->address}}</div>
                            </div>
                            <div class="order-detail px-2">
                                <div class="order-detail-title mt-1">Phone:</div>
                                <div>{{$order->phone}}</div>
                            </div>
                            <div class="order-detail px-2">
                                <div class="order-detail-title mt-1">Email:</div>
                                <div>{{$order->email}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row ">
            <div class="col-md-7">
                <div class="custom-panel card pt-2">
                    <div class="font-weight-bold text-secondary  py-3 px-3 cool-border-bottom">
                       Order Details
                    </div>
                    <div class="full-details d-flex flex-column px-3">
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Product QRcode:</div>
                                <div class="col-sm-8">
                                    <img src="/{{$order->barcode}}" class="img-fluid" alt="Product QRcode">
                                </div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Service type:</div>
                                <div class="col-sm-8"> {{$order->service_type}}</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Registration date:</div>
                                <div class="col-sm-8"> {{$order->created_at->DiffForHumans(['parts' => 2,'short' => true])}}</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Due date:</div>
                                <div class="col-sm-8">
                                    {{Carbon\Carbon::parse($order->due_date)->toDateTimeString()}}
                                </div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Delivery date:</div>
                                <div class="col-sm-8">
                                    {{Carbon\Carbon::parse($order->due_date)->subHours(3)->toDateTimeString()}}
                                </div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Rider assigned:</div>
                                <div class="col-sm-8"> {{$order->rider_id}}</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">District:</div>
                                <div class="col-sm-8">{{$order->route->district}}</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Route:</div>
                                <div class="col-sm-8">{{$order->route->name}}</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Parcel size:</div>
                                <div class="col-sm-8"> {{$order->parcel_size}}g</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Quantity:</div>
                                <div class="col-sm-8">{{$order->parcel_quantity}}</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Pickup address:</div>
                                <div class="col-sm-8"> {{$order->pick_up_address}}</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Pickup landmark:</div>
                                <div class="col-sm-8"> {{$order->pick_up_landmark}}</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Delivery address:</div>
                                <div class="col-sm-8"> {{$order->delivery_address}}</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Delivery landmark:</div>
                                <div class="col-sm-8"> {{$order->delivery_landmark}}</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Description:</div>
                                <div class="col-sm-8"> {{$order->description}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="custom-panel card pt-2">
                    <div class="font-weight-bold text-secondary py-3 px-3 cool-border-bottom">
                        Order Timeline
                    </div>
                    <div class="full-details">
                        <div class="list-group list-group-flush">
                            @foreach($order->events as $event)
                            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start ">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{$event->status}}</h6>
                                    <small>{{$event->created_at->diffForHumans()}}</small>
                                </div>
                                <p class="mb-1 font-weight-normal">{{$event->comment}} </p>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
