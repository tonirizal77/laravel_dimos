<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{-- @php
    $theme = "ui_flexstart"
@endphp --}}
<head>
    <meta name="google-site-verification" content="3UkIO9MgWp9DhfGAayLQOW6IRDstgeGf8ZttVolM8sE" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi Kasir Online yang berbasis Android dan Web, simple dan praktis digunakan juga memudahkan pencatatan transaksi penjualan usaha, baik online ataupun offline.">
    <meta name="keywords" content="aplikasi kasir online, kasir online, point of sale, aplikasi inventory" >
    <meta name="Author" content="Sidimos Group - Toni Rizal" />
    <meta name="Copyright" content="{{date('Y')}} - {{$website->nama}}" />
    <meta charset="utf-8">

    @yield('title')

    <!-- Favicons -->
    <link href="{{ asset($theme.'/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset($theme.'/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset($theme.'/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset($theme.'/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset($theme.'/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset($theme.'/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset($theme.'/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset($theme.'/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Template CSS additional File -->
    @yield('css-x')

    <!-- Template Main CSS File -->
    <link href="{{ asset($theme.'/assets/css/style.css') }}" rel="stylesheet">

</head>

<body>
    <!-- ======= Header ======= -->
    @include($theme.'.layouts.header')

    <!-- ======= Main Content ======= -->
    @yield('content')

    <!-- ======= Footer ======= -->
    @include($theme.'.layouts.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset($theme.'/assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/purecounter/purecounter.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset($theme.'/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>

    <!-- Template Add JS File -->
    @yield('js-x')

    <script>
        // Preloader
        $(window).on('load', function () {
            if ($('#preloader').length) {
                $('#preloader').delay(100).fadeOut('slow', function () {
                    $(this).remove();
                });
            }
        });
    </script>

    <!-- Template Main JS File -->
    <script src="{{ asset($theme.'/assets/js/main.js') }}"></script>
</body>
</html>
