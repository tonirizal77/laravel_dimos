<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $theme = "ui_tempo"
@endphp
<head>
    @yield('title')
    <meta name="google-site-verification" content="3UkIO9MgWp9DhfGAayLQOW6IRDstgeGf8ZttVolM8sE" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" >
    <meta name="description" content="Aplikasi Kasir Online yang berbasis Android dan Web, simple dan praktis digunakan juga memudahkan pencatatan transaksi penjualan usaha, baik online ataupun offline.">
    <meta name="keywords" content="aplikasi kasir online, kasir online, point of sale, aplikasi inventory" >
    <meta name="Author" content="Sidimos Group - Toni Rizal" />
    <meta name="Copyright" content="{{date('Y')}} - {{$website->nama}}" />

    <!-- Favicons -->
    <link href="{{asset($theme.'/assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset($theme.'/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset($theme.'/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset($theme.'/assets/vendor/icofont/icofont.min.css') }}" rel="stylesheet">
    <link href="{{ asset($theme.'/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset($theme.'/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset($theme.'/assets/vendor/venobox/venobox.css') }}" rel="stylesheet">
    <link href="{{ asset($theme.'/assets/vendor/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset($theme.'/assets/css/style.css')}}" rel="stylesheet">
    <!-- Template CSS additional File -->
    @yield('css-x')
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center justify-content-between">

            {{-- <h1 class="logo">
                <a href="{{url('#header')}}" class="scrollto">{{ $website->nama }}</a>
            </h1> --}}
            <!-- Uncomment below if you prefer to use an image logo -->

            <a href="{{url('#header')}}" class="logo scrollto">
                <img src="{{ asset($theme.'/assets/img/logo.png')}}" alt="" class="img-fluid">
            </a>

            <nav class="nav-menu d-none d-lg-block">
                <ul>
                    <!-- <li class="drop-down"><a href="">Drop Down</a>
                        <ul>
                            <li><a href="#">Drop Down 1</a></li>
                            <li class="drop-down"><a href="#">Deep Drop Down</a>
                                <ul>
                                <li><a href="#">Deep Drop Down 1</a></li>
                                <li><a href="#">Deep Drop Down 2</a></li>
                                <li><a href="#">Deep Drop Down 3</a></li>
                                <li><a href="#">Deep Drop Down 4</a></li>
                                <li><a href="#">Deep Drop Down 5</a></li>
                                </ul>
                            </li>
                            <li><a href="#">Drop Down 2</a></li>
                            <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li>
                        </ul>
                    </li> -->
                    <li class="active"><a href="{{url('#header')}}" class="scrollto">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#portfolio">Portfolio</a></li>
                    <li><a href="#pricing">Price</a></li>
                    <li><a href="#team">Team</a></li>
                    <!-- <li><a href="#contact">Contact</a></li> -->

                    @if (Route::has('login'))
                        @auth
                            @php
                                $role = DB::table('roles')->where('id', Auth::user()->role_id)->first();
                                $px = $role->redirect_to;
                            @endphp
                            {{-- <li><a href="{{ url($px.'/dashboard') }}">Dashboard</a></li> --}}
                            <li><a href="{{ route('dashboard.index') }}">Go Dashboard</a></li>
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
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>{{ $website->nama }}</h3>
                        <p>{{ $website->alamat }}</p>
                        <br>
                        <p><i class="icofont-phone"></i> <strong>Phone:</strong> {{ $website->telp }}</p>
                        <p><i class="icofont-envelope"></i> <strong>Email:</strong> {{ $website->email }}</p>
                    </div>

                    <div class="col-lg-2 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Terms of service</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6 footer-newsletter">
                        <h4>Join Our Newsletter</h4>
                        <p>Dapatkan Info terbaru tentang promo dan lainnya, silahkan Subscribe sekarang juga!</p>
                        <form action="" method="post">
                            <input type="email" name="email">
                            <input type="submit" value="Subscribe">
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="container d-md-flex py-4">

        <div class="me-md-auto text-center text-md-start">
            <div class="copyright">
                &copy;{{date('Y')}} - <strong><span>{{ $website->nama }}</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                Designed by <a href="https://bootstrapmade.com/" target="_blank">BootstrapMade</a>
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

    <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset($theme.'/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/owl.carousel/owl.carousel.min.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset($theme.'/assets/js/main.js') }}"></script>
    <!-- Template Add JS File -->
    @yield('js-x')
</body>
</html>
