<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @yield('title')

    <meta name="google-site-verification" content="3UkIO9MgWp9DhfGAayLQOW6IRDstgeGf8ZttVolM8sE" />
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Aplikasi Kasir Online yang berbasis Android dan Web, simple dan praktis digunakan juga memudahkan pencatatan transaksi penjualan usaha, baik online ataupun offline." name="description">
    <meta content="aplikasi kasir online, kasir online, point of sale, aplikasi inventory" name="keywords">
    <meta name="Author" content="Sidimos Group - Toni Rizal" />
    <meta name="Copyright" content="{{date('Y')}} - {{$website->nama}}" />

    <!-- Favicons -->
    <link href="{{asset('ui_users/assets/img/icon-dimos.png')}}" rel="icon">
    <link href="{{asset('ui_users/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Fonts Face -->
    <link rel="stylesheet" href="{{asset('ui_users/assets/css/myfonts.css')}}" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('ui_users/assets/vendor/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('ui_users/assets/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
    <link href="{{asset('ui_users/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('ui_users/assets/vendor/animate.css/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('ui_users/assets/vendor/venobox/venobox.css')}}" rel="stylesheet">
    <link href="{{asset('ui_users/assets/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('ui_users/assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset('ui_users/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('ui_users/assets/vendor/player/plyr.css')}}" rel="stylesheet">

        <!-- Template Main CSS File -->
    <link href="{{asset('ui_users/assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('ui_users/assets/css/myresponsive.css')}}" rel="stylesheet">

    <!-- Template CSS additional File -->
    @yield('css-x')
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">

            <h1 class="logo mr-auto"><a href="{{url('#header')}}" class="scrollto"><span class="stroke">{{ $website->nama }}</span></a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

            <nav class="nav-menu d-none d-lg-block">
                <ul>
                    {{-- <li class="active"><a href="{{url('#header')}}">Beranda</a></li> --}}
                    <li><a href="{{url('#about-us')}}">Tentang Kami</a></li>
                    <li><a href="{{url('#services')}}">Jasa Layanan</a></li>
                    {{-- <li><a href="{{url('#video-present')}}">Video Tutorial</a></li> --}}
                    <li><a href="{{url('#price-list')}}">Harga</a></li>
                    {{-- <li><a href="{{url('#contact')}}">Contact Us</a></li> --}}

                    {{-- <li class="drop-down"><a href="#">Lainnya</a>
                        <ul>
                            <li><a href="{{url('/#about-us')}}">About Us</a></li>
                            <li><a href="team.html">Team</a></li>
                            <li><a href="testimonials.html">Testimonials</a></li>
                            <li class="drop-down"><a href="#">Deep Drop Down</a>
                                <ul>
                                    <li><a href="#">Deep Drop Down 1</a></li>
                                    <li><a href="#">Deep Drop Down 2</a></li>
                                    <li><a href="#">Deep Drop Down 3</a></li>
                                    <li><a href="#">Deep Drop Down 4</a></li>
                                    <li><a href="#">Deep Drop Down 5</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li> --}}


                    @if (Route::has('login'))
                        @auth
                            @php
                                $role = DB::table('roles')->where('id', Auth::user()->role_id)->first();
                                $px = $role->redirect_to;
                            @endphp
                            {{-- <li><a href="{{ url($px.'/dashboard') }}">Dashboard</a></li> --}}
                            <li><a href="{{ url('/dashboard') }}">Go Dashboard</a></li>
                        @else
                            <li><a href="{{ route('register', ['tp' => 'free'])}}">Daftar Gratis</a></li>
                            <li><a href="{{ route('login') }}">Login</a></li>
                        @endauth
                    @endif

                </ul>
            </nav><!-- .nav-menu -->
        </div>
    </header><!-- End Header -->

    @yield('content')

    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row justify-content-between">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3><span class="logo stroke">{{ $website->nama }}</span></h3>
                        <p>
                            {{ $website->alamat }}
                            <br>
                            <strong><i class="icofont-phone"></i> Phone : </strong> {{ $website->telp }}<br>
                            <strong><i class="icofont-envelope"></i> e-mail : </strong> {{ $website->email }}<br>
                        </p>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#header">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#about-us">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#services">Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web and Android Design</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Android Development</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>Join Our Newsletter</h4>
                        <p>Dapatkan Info terbaru tentang promo dan lainnya, silahkan Subscribe sekarang juga!</p>
                        <form id="subscribe">
                            <input type="email" name="email">
                            <input type="submit" value="Subscribe" disabled>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="container d-md-flex py-4">

            <div class="mr-md-auto text-center text-md-left">
                <div class="copyright p-2">
                    &copy;{{date('Y')}} Copyright By. <strong><span>{{$website->nama}}</span></strong>. All Rights Reserved
                </div>
            </div>
            <div class="social-links text-center text-md-right pt-3 pt-md-0">
                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{asset('ui_users/assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('ui_users/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('ui_users/assets/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('ui_users/assets/vendor/php-email-form/validate.js')}}"></script>
    {{-- <script src="{{asset('ui_users/assets/vendor/jquery-sticky/jquery.sticky.js')}}"></script> --}}
    <script src="{{asset('ui_users/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('ui_users/assets/vendor/venobox/venobox.min.js')}}"></script>
    <script src="{{asset('ui_users/assets/vendor/waypoints/jquery.waypoints.min.js')}}"></script>
    <script src="{{asset('ui_users/assets/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('ui_users/assets/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('ui_users/assets/vendor/player/plyr.js')}}"></script>

    <!-- Template Main JS File -->
    <script src="{{asset('ui_users/assets/js/main.js')}}"></script>
    <!-- Template Add JS File -->
    @yield('js-x')

</body>

</html>
