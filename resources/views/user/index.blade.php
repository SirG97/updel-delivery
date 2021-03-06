@include('includes\head')

<div>
    <nav class="navbar navbar-expand-lg navbar-light navbar-transparent fixed-top main-menu custom">
        <a class="navbar-brand " href="#"><img src="/img/favicon.png" style="height: 40px" alt=""class="img-fluid"><span> Updel Services</span></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active px-3">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="/about">About</a>
                </li>

                <li class="nav-item px-3">
                    <a class="nav-link" href="/services" >Services</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="/track">Track</a>
                </li>
                <li class="nav-item px-3">
                    <a class="nav-link" href="/faq">FAQ</a>
                </li>
                <li class="nav-item px-3 ">
                    <a class="nav-link" href="/contact">Contact us</a>
                </li>
            </ul>
        </div>
    </nav>
</div>
<div class="hero d-flex justify-content-start">
    <div class="align-self-center ml-3 hero-text-container">
        <h2 class="hero-h2">Nokion Updel Services</h2>
        <p class="hero-p font-weight-bold">Nationwide, super fast and reliable delivery you can trust</p>
        <a href="/contact" class="btn btn-danger cta-btn">Contact us</a>
    </div>
</div>
<section class="who">
    <div class="whotext-container text-black-50">
        <div class="do-you text-center font-weight-bold">Do you know who we are?</div>
        <div>Updel Services is a courier company borne out of the need to bridge the growing gap between the need for fast, flexible supply of delivery service and available options. Led by an experienced leadership team and a versatile operational group, we are here to serve as a premier partner to every business that believes that Customer service is important to their business growth.</div>
    </div>
</section>
<section class="how">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <img src="/img/deliveryguy.jpg" class="img-fluid" alt="">
            </div>
            <div class="col-md-6 how-list">
                <div class="how-heading">How we work</div>
                <p class="p-big">Delivering your package is just a breeze with the few following steps</p>

                <ul>
                    <li>
                        <i class="fa fa-check-circle text-success"></i>
                        Select an option from our list of services
                    </li>
                    <li>
                        <i class="fa fa-check-circle text-success"></i>
                        Call any of our customer care lines to manage your orders
                    </li>
                    <li>
                        <i class="fa fa-check-circle text-success"></i>
                        Complete transaction process via phone calls
                    </li>
                    <li>
                        <i class="fa fa-check-circle text-success"></i>
                        Make payments, via any of our channels
                    </li>
                    <li>
                        <i class="fa fa-check-circle text-success"></i>
                        Your package will be delivered
                    </li>
                </ul>
            </div>
        </div>
    </div>

</section>

<!-- start of core services-->
<div class="what">
    <div class="what-header">
        <h3>Our core services</h3>
    </div>
    <div class="what-widget">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="widget-item">
                        <div class="circle-icon">
                            <i class="fa fa-shopping-bag"></i>
                        </div>
                        <h6>Delivery Request</h6>
                        <p>Customer leaves us with delivery instructions, and parcel is delivered to their choice of address.</p>
                        <a href="/contact" class="btn btn-danger">Contact us</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="widget-item">
                        <div class="circle-icon">
                            <i class="fa fa-shipping-fast"></i>
                        </div>
                        <h6>Collection Request</h6>
                        <p>Parcels are picked up on customer's request and held till further instructions. Charges may apply.</p>
                        <a href="/contact" class="btn btn-danger">Contact us</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="widget-item">
                        <div class="circle-icon">
                            <i class="fa fa-truck-monster"></i>
                        </div>

                        <h6>Combo Request</h6>
                        <p>This is a unique service type where customer request for collection and delivery to address of choice.</p>
                        <a href="/contact" class="btn btn-danger">Contact us</a>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12">
                    <div class="widget-item">
                        <div class="circle-icon">
                            <i class="fa fa-handshake"></i>
                        </div>
                        <h6>Swap Request</h6>
                        <p>This service type is an exchange. A customer requests for a replacement of items already purchased.</p>
                        <a href="/contact" class="btn btn-danger">Contact us</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- End core services -->

{{--Call to action--}}
<section class="call-to-action">
    <div class="call-to-action-container d-flex justify-content-center p-4">
        <div class="call-to-action-text align-self-start align-self-md-center pl-5">
            <h3 class="font-weight-bold">Alright, contact us and let's get started</h3>
            <a href="/contact" class="btn btn-danger btn-lg cta-btn">Contact us</a>
        </div>

    </div>
    <img src="/img/delivery_van.jpg" class="img-fluid" alt="">
</section>
{{--End of call to action--}}

@include('includes\footer')

