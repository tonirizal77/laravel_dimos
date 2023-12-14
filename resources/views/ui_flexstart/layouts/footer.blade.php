<footer id="footer" class="footer">

    <!-- ======= Subscribe ======= -->
    {{-- @include($theme.'.component.subscribe') --}}

    <div class="footer-top">
        <div class="container">
            <div class="row gy-4 justify-content-between">
                <div class="col-lg-5 col-md-12 footer-info">
                    <a href="#hero" class="scrollto logo d-flex align-items-center">
                        <img src="{{ asset($theme.'/assets/img/logo.png')}}" alt="logo">
                        <span>{{ $website->nama }}</span>
                    </a>
                    <div class="footer-newsletter">
                        <h4>Join Our Newsletter</h4>
                        <div class="row">
                            <div class="col-sm-5 mb-2">
                                <p>Dapatkan Info terbaru promo dan lainnya, silahkan Subscribe sekarang juga!</p>
                            </div>
                            <div class="col-sm-7">
                                <form action="#" method="#">
                                    <input type="email" name="email">
                                    <input type="submit" value="Subscribe">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-2 col-6 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#about">About us</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#features">Features</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#pricing">Price</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                {{-- <div class="col-lg-2 col-6 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Graphic Design</a></li>
                    </ul>
                </div> --}}

                <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Contact Us</h4>
                    <p>
                        {{ $website->alamat }}, {{ $website->provinsi }}<br>
                        <i class="bi bi-telephone"></i> <strong>Phone:</strong> {{ $website->telp }}<br>
                        <i class="bi bi-envelope"></i> <strong>Email:</strong> {{ $website->email }}<br>
                    </p>
                    <div class="social-links mt-3">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram bx bxl-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin bx bxl-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="copyright">
            &copy;{{date('Y')}} - <strong><span>{{ $website->nama }}</span></strong> Group - All Rights Reserved
        </div>
        {{-- <div class="credits">
            Designed by <a href="https://bootstrapmade.com/" target="_blank">BootstrapMade</a>
        </div> --}}
    </div>
</footer><!-- End Footer -->

