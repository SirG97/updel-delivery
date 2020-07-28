{{--footer--}}
<section id="footer-container">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <h5>About Updel </h5>
                <p>UPdel Services is a courier company borne out of the need to bridge
                    the growing gap between the need for fast,
                    flexible supply of delivery service and available options.</p>
            </div>
            <div class="col-md-3 d-flex flex-column">
                <h5>Our Services</h5>
                <p>Delivery Request</p>
                <p>Collection Request</p>
                <p>Combo Request</p>
                <p>Swap Request</p>
            </div>
            <div class="col-md-3 d-flex flex-column">
                <h5>Sub Services</h5>
                <p>Premium Services</p>
                <p>Precise Delivery Services</p>
                <p>Same Day Delivery</p>
                <p>Two Day Delivery</p>
                <p><a href="/services">See more ...</a></p>
            </div>
            <div class="col-md-3">
                <h5>Contact us</h5>
                <p><i class="fa fa-map-marker-alt"></i> Nationwide</p>
                <div class="d-inline-flex mb-2 justify-content-between">
                    <div class="align-self-start"><i class="fa fa-envelope"></i></div> &nbsp;
                    <div>info@updelservices.com <br>updelservices@gmail.com</div>
                </div>
                <p><i class="fa fa-phone"></i> +2347040463183</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-10 col-md-12 col-sm-12">
                <div class="footer-social">
                    <ul>
                        <li><a href="#"><i class="fab fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fab fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                    </ul>
                </div>
                <div class="footer-nav text-center">
                    <ul>
                        <li><a href="" class="footer-lin">Home</a></li>
                        <li><a href="" class="footer-lin">About</a></li>
                        <li><a href="" class="footer-lin">Services</a></li>
                        <li><a href="" class="footer-lin">FAQ</a></li>
                        <li><a href="" class="footer-lin">Contact us</a></li>
                    </ul>
                </div>
                <div class="copyright text-center">
                    <p>Copyright © 2019 All Rights Reserved</p>
                </div>
            </div>
        </div>
    </div>
</section>
{{--footer section end--}}
<script>
    $(document).ready(() => {
        $('nav, .nav-item').toggleClass('nav-scrolled scroll-item', window.pageYOffset > 60);
        $(window).scroll(() => {
            $('nav, .nav-item').toggleClass('nav-scrolled scroll-item', $(this).scrollTop() > 60)
        });
    });
</script>
</body>
</html>