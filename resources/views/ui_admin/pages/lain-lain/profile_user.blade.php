@extends('ui_admin.layouts.main')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title')
    Profile User
@endsection

@section('title-page')
    <i class="fas fa-house-user"></i>
    Profile User
@endsection

@section('css-x')
    <!-- This Page -->
    <link rel="stylesheet" href="{{ asset('custom/css/style.css')}}">
    <style>
        :focus-visible {
            outline: auto 1px #17a2b8 !important;
        }

    </style>
@endsection

@php
    $roles = '-';
    switch (Auth::user()->role_id) {
        case '0':
            $roles = 'Owner';
            break;
        case '1':
            $roles = 'Admin';
            break;
        case '2':
            $roles = 'User';
            break;
        case '3':
            $roles = 'Kasir';
            break;
        case '4':
            $roles = 'Accounting';
            break;
        case '5':
            $roles = 'Staff';
            break;
    }
@endphp

@section('content')
    <!-- Main content -->
    <div class="content pt-2 pb-2">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="card card-info card-outline">
                    <div class="card-body box-profile">
                        <form id="form_user_profile" enctype="multipart/form-data">
                            <div id="method"></div>
                            @csrf
                            <div class="row justify-content-around">
                                <div class="col-md-4">
                                    <!-- Profile Image -->
                                    <div class="custom-upload-file text-center">
                                        <input type="file" name="inputFile" id="inputFile" onchange="previewFile(this)" disabled/>
                                        <label for="inputFile">
                                            <div class="box-img-circle">
                                                @if ($user->profilePicture != null)
                                                    <img id="previewImg"
                                                        src="{{url('/images/profile') .'/'. $user->profilePicture }}"
                                                        alt="User profile picture">
                                                @else
                                                    <img id="previewImg"
                                                        src="{{asset('ui_admin/dist/img/user7-128x128.jpg')}}"
                                                        alt="User profile picture">
                                                @endif
                                            </div>
                                        </label>
                                    </div>

                                    <h3 class="profile-username text-center">{{$user->name}}</h3>
                                    <p class="text-muted text-center">{{$user->email}}</p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Username</b> <a class="float-right">{{$user->username}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Akses ke Usaha</b> <a class="float-right">{{$user->nama_usaha}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Alamat Lengkap</b> <a class="float-right">{{$user->alamat}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Kota</b> <a class="float-right kota" data-prov="{{$user->prov_id}}" data-kota="{{$user->cities_id}}">{{$user->kota}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>No. Telpon</b> <a class="float-right">{{$user->telpon}}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Hak Akses</b> <a class="float-right">{{$roles}}</a>
                                        </li>

                                    </ul>
                                </div>

                                <div class="col-md-8">
                                    <div class="card card-info card-outline shadow-lg">
                                        <div class="card-header">
                                            <h3 class="card-title text-info"><i class="fas fa-house-user text-info"></i> Data User (Profile) </h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-outline-info btn-xs" data-id="{{$user->id}}" id="btn_edit_profile">
                                                    <i class="fas fa-edit"></i> Edit</button></a>
                                                <span id="btn_action_1"></span>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            {{-- <div class="row form-errors justify-content-center"></div> --}}
                                            {{-- User Profile Form --}}
                                            {{-- <div class="row custom-upload-file">
                                                <input type="file" name="inputFile" id="inputFile" onchange="previewFile(this)" disabled/>
                                            </div> --}}

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="nama_user">Nama Pengguna (user)</label>
                                                        <input type="text" class="form-control form-control-border" name="nama_user" id="nama_user" value="{{$user->name}}">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <!-- select -->
                                                    <div class="form-group">
                                                        <div class="d-flex justify-content-between">
                                                            <label class="col-form-label" for="telpon">No. Handphone</label>
                                                            <a href="email?=Handphone" class="nav-link text-danger text-sm">Verifikasi <i class="fas fa-bell-slash"></i> </a>
                                                        </div>
                                                        <input type="text" name="telpon" id="telpon" class="form-control form-control-border" value="{{$user->telpon}}" maxlength="15">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <!-- textarea -->
                                                    <div class="form-group">
                                                        <label>Alamat Lengkap</label>
                                                        <textarea name="alamat" id="alamat" class="form-control form-control-border" rows="3" placeholder="Alamat...">{{$user->alamat}}</textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="kota">Provinsi</label>
                                                        <select name="provinsi" id="provinsi" class="select2 form-control form-control-sm" style="width: 100%">
                                                            @forelse ( $provinsi as $prov )
                                                                @if ($prov->id == $user->prov_id)
                                                                    <option value={{ $prov->id }} selected>{{ $prov->name }}</option>
                                                                @else
                                                                    <option value={{ $prov->id }}>{{ $prov->name }}</option>
                                                                @endif
                                                            @empty
                                                                <option value="">Tidak Ada Data</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="kota">Kota/Kabupaten</label>
                                                        <select name="kota" id="kota" class="select2 form-control form-control-sm" style="width: 100%">
                                                            <option value="">Tidak Ada Data</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card card-info card-outline shadow-lg">
                                        <div class="card-header">
                                            <div class="row justify-content-between">
                                                <div class="col-6 ">
                                                    <h3 class="card-title text-info"><i class="fas fa-laptop"></i> Data Access</h3>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <button type="button" class="btn btn-xs btn-outline-info" id="btn_edit_access"><i class="fas fa-edit"></i> Edit</button>
                                                    <span id="btn_action_2"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <!-- select -->
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="username">Username / Kode</label>
                                                        <input type="text" name="username" maxlength="10" class="form-control form-control-border" id="username" autocomplete="off"  value="{{$user->username}}" disabled>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <div class="d-flex justify-content-between">
                                                            <label class="col-form-label" for="email">E-mail</label>
                                                            <a href="email?=verifikasi" class="nav-link text-danger text-sm">Verifikasi <i class="fas fa-bell-slash"></i> </a>
                                                        </div>

                                                        <input type="email" name="email" class="form-control form-control-border" id="email"  value="{{$user->email}}" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="password">Password Lama</label>
                                                        <div class="input-group">
                                                            <input type="password" name="password_lama" class="form-control form-control-border" value="******" autocomplete="off" id="password_lama" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="password">Password Baru</label>
                                                        <div class="input-group">
                                                            <input type="password" name="password" class="form-control form-control-border" value="" placeholder="" autocomplete="off" id="password" disabled>
                                                            <div class="input-group-append toggle-password">
                                                                <span id="toggle-password" class="input-group-text" style="padding: 2px 4px"><i class="fas fa-eye"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-x')
    <!-- bs-custom-file-input -->
    {{-- <script src="{{ asset('ui_admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script> --}}
    <!-- InputMask -->
    <script src="{{ asset('ui_admin/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    {{-- jquery Foam --}}
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.form.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.validate.js') }}"></script>
    <!-- This page -->
    <script src="{{ asset('custom/js/myjs.js')}}"></script>
    <script src="{{ asset('custom/js/lain-lain/profile-user.js')}}"></script>

    <script>
        function previewFile(filex){
            var filex = $("input[type=file]").get(0).files[0];
            if(filex){
                let reader = new FileReader();
                reader.onload = function(){
                    $("#previewImg").attr("src", reader.result);
                }
                reader.readAsDataURL(filex);
            }
        }
    </script>
@endsection
