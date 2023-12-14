<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @yield('token')
    <title>@yield('title')</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('ui_admin/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('ui_admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('ui_admin/plugins/toastr/toastr.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('ui_admin/dist/css/adminlte.min.css')}}">

    @yield('css-x')
</head>

<body class="hold-transition">

    @yield('content')

    <!-- jQuery -->
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('ui_admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- toastr 2.1.3 -->
    <script src="{{ asset('ui_admin/plugins/toastr/toastr.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{ asset('ui_admin/plugins/iCheck/icheck.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('ui_admin/dist/js/adminlte.min.js') }}"></script>

    @yield('js-x')
</body>

</html>
