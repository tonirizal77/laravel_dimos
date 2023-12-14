@extends('ui_admin.layouts.main')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title')
    Profile Usaha / Toko
@endsection

@section('title-page')
    <i class="fas fa-house-user"></i>
    Profile Usaha / Toko
@endsection

@section('css-x')
    <!-- This Page -->
    <link rel="stylesheet" href="{{ asset('custom/css/style.css')}}">
    <style>
        :focus-visible {
            outline: auto 1px #17a2b8 !important;
        }
        .card-header .nav-link.active {
            background-color: #17a2b8 !important;
        }
        .table td {
            padding: 0 !important;
        }
        .table td.kuning {
            color: yellow;
        }
        .gambar_akun {
            width: 180px;
            height: 150px;
        }

    </style>
@endsection

@php
    function rupiah($angka){
        // $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,',',',');
        return $hasil_rupiah;
    };
    $roles = '-';
    switch (Auth::user()->role_id) {
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
            $roles = 'Lainnya';
            break;
    }

@endphp

@section('content')
    <div class="content pt-2 pb-2">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline mb-0">
                    <div class="card-body box-profile">
                        <div class="row justify-content-around">
                            <div class="col-md-3">
                                {{-- <div class="d-inline-block">
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i> Change Screen</button>
                                </div> --}}
                                <div class="text-small text-info text-center">Logo Usaha / Toko</div>
                                <p class="text-center text-sm text-info">Dicetak di-Struk Penjualan</p>
                                <div class="custom-upload-file text-center">
                                    <label for="inputFile">
                                        <div class="box-img-logo">
                                            <img src="/images/profile/logo-usaha.png" id="previewImg" alt="Logo Usaha">
                                        </div>
                                    </label>
                                </div>

                                @if (Auth::user()->usaha_id != null)
                                    <div class="custom-upload-file text-center">
                                        {{-- Ganti Logo --}}
                                        <form id="form_ganti_logo" enctype="multipart/form-data">
                                            <div id="method2"></div>
                                            @csrf
                                            <input type="file" class="btn btn-outline-info btn-xs" name="ganti_logo" id="ganti_logo">
                                            <label for="ganti_logo" class="btn btn-outline-info btn-xs" id="label_ganti">
                                                <i class="fas fa-edit"></i> Ganti Logo
                                            </label>
                                            <span id="btn_action_logo"></span>
                                        </form>
                                    </div>
                                @endif

                                <h3 class="profile-username text-bold text-center" id="info_nama"></h3>
                                <p class="text-muted text-center" id="info_email"></p>

                                <ul class="list-group list-group-unbordered mb-3">

                                    <li class="list-group-item">
                                        <b>Alamat Lengkap</b> <a class="float-right" id="info_alamat"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Kota</b> <a class="float-right kota" id="info_kota"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>No. Telpon</b> <a class="float-right" id="info_telpon"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Status Akun</b> <a class="float-right" id="info_akun"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Status Usaha</b> <a class="float-right" id="info_status"></a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Pemilik Usaha</b> <a class="float-right" id="info_pemilik">{{Auth::user()->name}}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Hak Akses Pemilik</b> <a class="float-right" id="info_roles">{{$roles}}</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <form id="form_toko" enctype="multipart/form-data">
                                            <div id="method"></div>
                                            @csrf
                                            <div class="card card-info card-outline shadow-lg">
                                                <div class="card-header">
                                                    <h3 class="card-title text-info"><i class="fas fa-house-user"></i> Data Usaha (Toko) </h3>
                                                </div>
                                                <div class="card-body">
                                                    {{-- User Profile Form --}}
                                                    <div class="row custom-upload-file">
                                                        <input type="file" name="inputFile" id="inputFile" disabled/>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label" for="nama">Nama Usaha / Toko</label>
                                                                <input type="text" name="nama" id="nama" class="form-control form-control-border">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label" for="telpon">No. Telpon</label>
                                                                <input type="text" name="telpon" id="telpon" class="form-control form-control-border" maxlength="15">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Alamat E-Mail</label>
                                                                <input type="email" name="email" id="email" class="form-control form-control-border">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 d-flex align-self-center">
                                                            <button type="button" class="btn btn-xs btn-outline-warning mr-2" id="verifikasi_email" disabled>Verifikasi e-Mail</button>
                                                            <button type="button" class="btn btn-xs btn-outline-warning" id="verifikasi_telpon" disabled>Verifikasi Telpon</button>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group">
                                                                <label>Alamat Toko</label>
                                                                <textarea name="alamat" id="alamat" class="form-control form-control-border" rows="3" placeholder="Alamat..."></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label" for="kota">Provinsi</label>
                                                                <select name="provinsi" id="provinsi" class="select2 form-control form-control-sm" style="width: 100%"></select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label" for="kota">Kota/Kabupaten</label>
                                                                <select name="kota" id="kota" class="select2 form-control form-control-sm" style="width: 100%"></select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-center">
                                                    <button type="button" class="btn btn-outline-info btn-xs d-none" id="btn_buat">
                                                        <i class="fas fa-plus-square"></i> Buat Toko
                                                    </button>

                                                    <button type="button" class="btn btn-outline-info btn-xs" data-id="" id="btn_edit">
                                                        <i class="fas fa-edit"></i> Edit Data Usaha
                                                    </button>
                                                    <span id="btn_action"></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row pt-0 pl-2 pr-2 pb-2">
                                    <div class="row form-errors justify-content-center"></div>
                                </div>
                            </div><!--cols-2-->
                        </div><!--row-->
                    </div><!--card-body-->
                </div><!--card-main-->
            </div><!--col-12-->
        </div><!--row-->
    </div><!--content-->
@endsection

@section('js-x')
    <!-- InputMask -->
    <script src="{{ asset('ui_admin/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    {{-- jquery Foam --}}
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.form.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.validate.js') }}"></script>
    <!-- This page -->
    <script src="{{ asset('custom/js/myjs.js')}}"></script>
    <script src="{{ asset('custom/js/lain-lain/profile-usaha.js')}}"></script>
@endsection
