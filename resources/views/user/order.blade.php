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
                            <div class="">Combo Request</div>
                            <div class="order-name">Pair of shoe<span><i class="fas fa-fw fa-check-circle text-success"></i></span></div>

                        </div>
                        <div class="font-weight-bold text-secondary mb-1 d-flex justify-content-end">
                            <div class="text-right">
                                Order ID: 1215FS8KJGSK
                            </div>

                        </div>
                    </div>
                    <div class="order-details-container cool-border-top">
                        <div class="order-details d-flex flex-column flex-sm-row py-3">
                            <div class="order-detail px-2">
                                <div class="order-detail-title mt-1">Name</div>
                                <div>Jennifer Peters</div>
                            </div>
                            <div class="order-detail px-2">
                                <div class="order-detail-title mt-1">Address:</div>
                                <div>No 10 Obanye Streeet, Onitsha</div>
                            </div>
                            <div class="order-detail px-2">
                                <div class="order-detail-title mt-1">Phone:</div>
                                <div>09076545362</div>
                            </div>
                            <div class="order-detail px-2">
                                <div class="order-detail-title mt-1">Email:</div>
                                <div>jondoe@gmail.com</div>
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
                                <div class="col-sm-4 order-detail-title">Registration date:</div>
                                <div class="col-sm-8"> 1st June 2020</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Due date:</div>
                                <div class="col-sm-8"> 1st June 2020</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Delivery date:</div>
                                <div class="col-sm-8"> 1st June 2020</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Rider assigned:</div>
                                <div class="col-sm-8"> Jonny Chase</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">District:</div>
                                <div class="col-sm-8"> Maitama</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Route:</div>
                                <div class="col-sm-8"> Awolowo drive, Kubwa junction Maitama</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Parcel size:</div>
                                <div class="col-sm-8"> 110g</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Quantity:</div>
                                <div class="col-sm-8"> 1</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Pickup address:</div>
                                <div class="col-sm-8"> 1 Isioko Street, Anam</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Pickup landmark:</div>
                                <div class="col-sm-8"> Anyara junction</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Delivery address:</div>
                                <div class="col-sm-8"> 1 akuwnna Lane, Mile 2</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Delivery landmark:</div>
                                <div class="col-sm-8"> Ikeja junction</div>
                            </div>
                        </div>
                        <div class="full-details-item">
                            <div class="d-flex row my-1">
                                <div class="col-sm-4 order-detail-title">Description:</div>
                                <div class="col-sm-8"> This is a package for my sweetheart in Lagos. fuck you</div>
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
                            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start ">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Registered</h6>
                                    <small>3 days ago</small>
                                </div>
                                <p class="mb-1">Donec id elit non mi porta gravida at eget metus. </p>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Ongoing</h6>
                                    <small class="text-muted">3 days ago</small>
                                </div>
                                <p class="mb-1">Donec id elit non mi porta gravida.</p>

                            </a>
                            <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">Delivered</h6>
                                    <small class="text-muted">3 days ago</small>
                                </div>
                                <p class="mb-1">Donec id elit non mi porta gravida at eget </p>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection()
