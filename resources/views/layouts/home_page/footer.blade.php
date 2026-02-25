<!-- Footer-Section start -->
<footer>
    <div class="top_footer" id="contact">
        <!-- container start -->
        <div class="container">
            <!-- row start -->
            <div class="row">
                <span class="banner_shape1"> <img src="{{ asset('assets/web-site-images/banner-shape1.png') }}"
                        alt="image">
                </span>
                <span class="banner_shape2"> <img src="{{ asset('assets/web-site-images/banner-shape2.png') }}"
                        alt="image">
                </span>
                <span class="banner_shape3"> <img src="{{ asset('assets/web-site-images/banner-shape3.png') }}"
                        alt="image">
                </span>
                <!-- footer link 1 -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="abt_side">
                        <div class="logo"> <img src="{{ asset('assets/web-site-images/footer_logo.png') }}" alt="image">
                        </div>
                        <ul>
                            <li><a href="#">info@sarthakedge.com</a></li>
                            <li><a href="#">+91 81797 09818</a></li>
                        </ul>
                        <ul class="social_media">
                            <li><a href="#"><i class="icofont-facebook"></i></a></li>
                            <li><a href="#"><i class="icofont-twitter"></i></a></li>
                            <li><a href="#"><i class="icofont-instagram"></i></a></li>
                            <li><a href="#"><i class="icofont-pinterest"></i></a></li>
                        </ul>
                    </div>
                </div>

                <!-- footer link 2 -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="links">
                        <h3>Useful Links</h3>
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ url('/#features') }}">Features</a></li>
                            <li><a href="{{ url('/#how_it_work') }}">About Us</a></li>
                            <li><a href="{{ route('pricing') }}">Pricing</a></li>
                            <li><a href="{{ url('/#contact') }}">Contact us</a></li>
                        </ul>
                    </div>
                </div>

                <!-- footer link 3 -->
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="links">
                        <h3>Help & Suport</h3>
                        <ul>

                            <li><a href="{{ url('/#contact') }}">Support</a></li>
                            <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('terms-conditions') }}">Terms & conditions</a></li>
                            <li><a href="{{ route('refund-policy') }}">Refund Policy</a></li>
                            <li><a href="{{ route('data-security') }}">Data Security Policy</a></li>
                            <li><a href="{{ route('cookies-policy') }}">Cookies Policy</a></li>

                        </ul>
                    </div>
                </div>


            </div>
            <!-- row end -->
        </div>
        <!-- container end -->
    </div>

    <!-- last footer -->
    <div class="bottom_footer">
        <!-- container start -->
        <div class="container">
            <!-- row start -->
            <div class="row">
                <div class="col-md-6">
                    <p>© 2026 SARTHAKEDGE IT SOLUTIONS PRIVATE LIMITED. All Rights Reserved.</p>
                </div>

            </div>
            <!-- row end -->
        </div>
        <!-- container end -->
    </div>

    <!-- go top button -->
    <div class="go_top">
        <span><img src="{{ asset('assets/web-site-images/go_top.png') }}" alt="image"></span>
    </div>
</footer>
<!-- Footer-Section end -->