<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('token')
    <title>@yield('title')</title>

    <link rel="icon" href="{{asset('ui_users/assets/img/icon-dimos.png')}}" >

    <!-- Google Font: Source Sans Pro
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    -->
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('ui_admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('ui_admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('ui_admin/plugins/select2/css/select2.min.css')}} ">
    <link rel="stylesheet" href="{{asset('ui_admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('ui_admin/plugins/toastr/toastr.min.css')}}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('ui_admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}} ">
    <!-- bootstrap DateRangePicker -->
    <link rel="stylesheet" href="{{asset('ui_admin/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- sweetalert2 -->
    <link rel="stylesheet" href="{{asset('ui_admin/plugins/sweetalert2/sweetalert2.css')}}">
    <!-- pace-progress -->
    <link rel="stylesheet" href="{{asset('ui_admin/plugins/pace-progress/themes/black/pace-theme-flat-top.css')}}">
    @yield('css-x')
    @yield('topjs-x')
    <!-- Theme style, posisi the end -->
    <link rel="stylesheet" href="{{ asset('ui_admin/dist/css/adminlte.css') }}">
</head>
{{-- layout-fixed layout-navbar-fixed --}}
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed pace-warning pace-center-circle-warning">
    <div class="wrapper">
        <!-- Navbar -->
        @include('ui_admin.layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('ui_admin.layouts.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        @include('ui_admin.layouts.controlSidebar')
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('ui_admin.layouts.footer')

    </div>
    <!-- ./wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('ui_admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('ui_admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- sweetalert2 -->
    <script src="{{ asset('ui_admin/plugins/sweetalert2/sweetalert2.js')}}"></script>
    <!-- toastr 2.1.3 -->
    <script src="{{ asset('ui_admin/plugins/toastr/toastr.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('ui_admin/dist/js/adminlte.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('ui_admin/plugins/select2/js/select2.full.min.js')}} "></script>
    <!-- toastr 2.1.3 -->
    <script src="{{ asset('ui_admin/plugins/toastr/toastr.min.js')}}"></script>
    <!-- iCheck -->
    <script src="{{ asset('ui_admin/plugins/iCheck/icheck.js')}}"></script>
    <!-- moment -->
    <script src="{{ asset('ui_admin/plugins/moment/moment.min.js')}}"></script>
    <!-- bootstrap daterangepicker -->
    <script src="{{ asset('ui_admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- pace-progress -->
    <script src="{{ asset('ui_admin/plugins/pace-progress/pace.min.js')}}"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip({
                boundary: 'window',
                container: 'body',
                html: true,
            })
        })
    </script>
    @yield('js-x')
</body>
</html>
