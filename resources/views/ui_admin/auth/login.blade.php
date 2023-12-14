@extends('ui_admin.auth.index')

@section('title', 'Login Page')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                {{-- <a href="{{url('/')}}" class="h1"><b>Login</b> Page</a> --}}
                <div class="row justify-content-center">
                    <div class="col-md-3 d-flex align-self-center">
                        <div class="image d-flex" style="width: fit-content">
                            <img src="{{asset('ui_admin/dist/img/logo_dimos_2.png')}}" class="img-circle elevation-2" alt="User Image"
                            style="height: 75px" >
                        </div>
                    </div>
                    <div class="col-md-9">
                        <a href="{{url('/')}}" class="h1"><b>SiDiMoS</b></a>
                        <p class="mb-0">Simple Distribution Management Online System</p>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="{{ route('login')}}" method="post">
                    @csrf

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

                    <div class="form-group">
                        <label for="username">Username / Email</label>
                        <div class="input-group has-feedback">
                            <input type="string" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" autocomplete="username" autofocus placeholder="Username/Email" name="username">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group has-feedback">
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" autocomplete="current-password" placeholder="Password" name="password">
                                {{-- <span style="cursor: pointer" class="input-group-addon toggle-password"><i class="fa fa-eye"></i></span> --}}
                                <div class="input-group-append toggle-password">
                                    <div class="input-group-text">
                                        {{-- <span class="fas fa-lock"></span> --}}
                                        <i class="fa fa-eye"></i>
                                    </div>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Ingatkan Saya</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-success btn-sm btn-block">Masuk</button>
                        </div>
                    </div>
                </form>
                <hr>
                {{-- <p class="mb-1 text-center">
                    <a href="#">Saya lupa password</a>
                </p> --}}

                <p class="mb-0 text-center">
                    <a href="{{route('register')}}">Belum punya akun, Ingin Daftar</a>
                </p>
            </div>
        </div>
    </div>
@endsection

@section('js-x')
    <script>
        $(function(){
            $("body").addClass('login-page');

            let spass = $(".toggle-password");
            spass.css("cursor: pointer");

            $("body").on('click', '.toggle-password', function() {
                let ipass = $("input[name=password]")
                if (ipass.attr("type") === "password") {
                    ipass.attr("type", "text");
                } else {
                    ipass.attr("type", "password");
                }
                $("i.fa").toggleClass("fa-eye-slash");

            });
        })
    </script>
@endsection
