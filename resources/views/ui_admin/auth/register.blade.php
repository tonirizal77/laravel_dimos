@extends('ui_admin.auth.index')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title','Registration Member')

@section('content')
<div class="register-box" style="width: 560px">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <div class="row">
                <div class="col-md-2">
                    <div class="image" style="width: fit-content">
                        <img src="{{asset('ui_admin/dist/img/logo_dimos_2.png')}}" class="img-circle elevation-2" alt="User Image"
                           style="height: 75px" >
                    </div>
                </div>
                <div class="col-md-10">
                    <a href="{{ route('homepage')}}" class="h1"><b>SiDiMoS</b></a>
                    <p class="mb-0">Simple Distribution Management Online System</p>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h4 class="login-box-msg">Pendaftaran Anggota Baru</h4>
            <!-- TAMPILKAN NOTIF JIKA GAGAL LOGIN  -->
            @if(session('errors'))
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif

            @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
            @endif

            {{-- <form id="register" action="{{route('register')}}" method="post" style="margin-bottom: 20px"> --}}
            <form id="register" style="margin-bottom: 20px">
                @csrf
                {{-- <div class="row">
                    <input type="hidden" name="paket" value="{{ $tipe }}">
                </div> --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label class="col-form-label" for="nama_usaha">Nama Toko</label>
                            <input type="text" class="form-control" placeholder="Nama Usaha / Toko" name="nama_usaha" id="nama_usaha">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label class="col-form-label" for="username">Username</label>
                            <input type="text" class="form-control" placeholder="Username" autocomplete="off" name="username" id="username" maxlength="20" minlength="6">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label class="col-form-label" for="email">Email</label>
                            <input type="email" class="form-control" autocomplete="off" placeholder="Email" name="email" id="email">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-feedback">
                            <label class="col-form-label" for="password">Password</label>
                            <input type="password" class="form-control" placeholder="Password" name="password" id="password">
                        </div>
                    </div>
                </div>

                <div class="row justify-content-between">
                    <div class="col-md-8">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="setuju">
                            <label for="setuju" class="text-secondary"></label>
                            <span class="text-info">Saya setuju dengan syarat dan ketentuannya.</span>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-4">
                        <button type="button" class="btn btn-sm btn-primary btn-block" id="btn-create">Buat Toko Saya</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>

            <hr>
            <p class="mb-1 text-center">
                <a href="{{url('login')}}" class="text-center">Sudah punya akun, silahkan Login</a>
            </p>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- /.register-box -->
@endsection

@section('js-x')
    <!-- InputMask -->
    <script src="{{ asset('ui_admin/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    {{-- jquery Foam --}}
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.form.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.validate.js') }}"></script>
    <!-- This page -->
    <script>
        $("body").addClass('register-page');
        $("button#btn-create").prop("disabled", true);
    </script>
    <script src="{{asset('custom/js/myjs.js')}}"></script>
    <script src="{{asset('custom/js/lain-lain/register.js')}}"></script>
@endsection
