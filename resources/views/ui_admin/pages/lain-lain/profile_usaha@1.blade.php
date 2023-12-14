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
                                <div class="text-small text-info text-center">Logo Usaha / Toko</div>
                                <p class="text-center text-sm text-info">Dicetak di-Struk Penjualan</p>
                                <div class="custom-upload-file text-center">
                                    <label for="inputFile">
                                        <div class="box-img-logo">
                                            <img src="/profile/logo-usaha.png" id="previewImg" alt="Logo Usaha">
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
                                        <div class="progress" style="width: 100%;display:none">
                                            <div class="progress-bar bg-primary progress-bar-striped"
                                                role="progressbar" aria-valuenow="40"
                                                aria-valuemin="0" aria-valuemax="100"
                                                style="width: 40%">
                                                <span class="percent">0% Complete (success)</span>
                                            </div>
                                        </div>
                                        <div class="row col-12 justify-content-center mt-1" id="action_paket"></div>
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
                                <div class="card shadow-lg">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills nav-compact">
                                            <li class="nav-item"><a class="nav-link active" href="#pengaturan" data-toggle="tab">Data Usaha/Toko (Utama)</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#list-order" data-toggle="tab">Daftar Order Paket Akun</a></li>
                                            <li class="nav-item"><a class="nav-link" href="#pakets" data-toggle="tab" id="listpakets">Daftar Paket Layanan</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="pengaturan">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <form id="form_toko" enctype="multipart/form-data">
                                                            <div id="method"></div>
                                                            @csrf
                                                            <div class="card card-info card-outline">
                                                                <div class="card-header">
                                                                    <h3 class="card-title text-info"><i class="fas fa-house-user"></i> Data Usaha (Toko) </h3>
                                                                    <div class="card-tools">
                                                                        <button type="button" class="btn btn-outline-info btn-xs d-none" id="btn_buat">
                                                                            <i class="fas fa-plus-square"></i> Buat Toko
                                                                        </button>

                                                                        <button type="button" class="btn btn-outline-info btn-xs" data-id="" id="btn_edit">
                                                                            <i class="fas fa-edit"></i> Edit
                                                                        </button>
                                                                        <span id="btn_action"></span>
                                                                    </div>
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
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="card bg-info shadow">
                                                            <div class="card-header">
                                                                <h3 class="card-title"><i class="fas fa-laptop"></i> Data Akun Usaha</h3>
                                                            </div>
                                                            <div class="card-body" id="box_akun"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="list-order">
                                                {{-- Tabel Paket Aktif --}}
                                                <h5 class="text-left"><i class="text-info fas fa-clinic-medical"></i> Daftar Order Paket Akun</h5>
                                                <table class="table table-bordered table-hover table-head-fixed" id="tabel_orders">
                                                    <thead class="text-center align-self-center">
                                                        <tr>
                                                            <th rowspan="2" style="width: 5%">No</th>
                                                            <th rowspan="2">Nama Paket</th>
                                                            <th rowspan="2">No Order</th>
                                                            <th colspan="2">Status</th>
                                                            <th rowspan="2" style="width: 8%">Durasi</th>
                                                            <th rowspan="2">Total</th>
                                                            <th rowspan="2" style="width: 10%">Tanggal<br>Dibuat</th>
                                                            <th rowspan="2" style="width: 10%">Aksi</th>
                                                        </tr>
                                                        <tr>
                                                            <th style="width: 10%">Order</th>
                                                            <th style="width: 10%">Payment</th>
                                                        </tr>
                                                    </thead>
                                                    {{-- isian rincian data --}}
                                                    <tbody>
                                                        <tr><td colspan="8" class="text-center">Data Order Belum Tersedia</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="tab-pane" id="pakets">
                                                {{-- Daftar Paket --}}
                                                <div class="row justify-content-between">
                                                    <h5 class="text-left"><i class="text-info fab fa-asymmetrik"></i> Daftar Paket Layanan</h5>
                                                    <div class="col-md-2 text-right">
                                                        <button type="button" class="btn btn-outline-success btn-sm" id="btn_lanjut" disabled>
                                                            <i class="fas fa-handshake"></i> Lanjutkan
                                                        </button>
                                                    </div>
                                                </div>
                                                <hr>

                                                <div class="row justify-content-center align-items-start" id="box-paket">
                                                    @for ($i = 1; $i < count($paket); $i++)
                                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 radio-custom-paket">
                                                            <input type="radio" name="pilih_paket" value="{{ $paket[$i]->id }}"
                                                                data-bayarid="{{$paket[$i]->id.'-2'}}"
                                                                id="{{ 'Paket-'.$paket[$i]->name }}">

                                                            <label for="{{ 'Paket-'.$paket[$i]->name }}">
                                                                <div class="card {{ $paket[$i]->warna_header }} shadow-none">
                                                                    <div class="card-header">
                                                                        {{ "Paket ".$paket[$i]->name }}
                                                                        @if ($paket[$i]->disc != 0)
                                                                            <span class="disc">Disc {{$paket[$i]->disc}}%</span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="card-body {{ $paket[$i]->warna_body }} text-center">

                                                                        <div class="row align-self-center">
                                                                            <div class="col-sm-5 d-flex justify-content-center">
                                                                                <div class="d-flex p-2">
                                                                                    <img class="d-flex" src="{{ asset('custom/gambar/'.$paket[$i]->gambar) }}" alt="{{ 'Paket-'.$paket[$i]->name }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-7 align-self-center">
                                                                                <p class="biaya">Rp. {{rupiah($paket[$i]->biaya)}}/bulan</p>
                                                                                <p class="ket">{{$paket[$i]->keterangan}}</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row text-left">
                                                                            {{-- <p class="uraian">{{$paket[$i]->uraian}} x Rp. <span class="text-light text-bold">{{rupiah($paket[$i]->biaya)}}</span></p> --}}
                                                                            <p class="text-yellow">Ketentuan:</p>
                                                                            @php
                                                                                $fasilitas = explode(",", $paket[$i]->max_features);
                                                                                $warna = ['icheck-info','icheck-success','icheck-danger','icheck-dark','icheck-primary']
                                                                            @endphp
                                                                            <ol  style="padding-inline-start: 20px">
                                                                                <li>Max. Product : {{ $fasilitas[0] }} Product</li>
                                                                                <li>Max. Outlet/Toko : {{ $fasilitas[1] }} Outlet</li>
                                                                                <li>Max. Trx.Sale : {{ $fasilitas[2] }} Trx/bulan</li>
                                                                            </ol>
                                                                        </div>
                                                                        <div class="row opsi-bayar">
                                                                            <p class="text-yellow">Pilih Pembayaran:</p>
                                                                            <div class="col-12">
                                                                                <div class="form-group clearfix">
                                                                                    <div class="{{$warna[$i]}} d-inline">
                                                                                        <input type="radio" id="{{$paket[$i]->id.'-1'}}"
                                                                                            data-paketid="{{ $paket[$i]->id }}"
                                                                                            data-paket="{{ 'Paket-'.$paket[$i]->name }}"
                                                                                            data-harga="{{$paket[$i]->biaya*6}}"
                                                                                            value="6" name="opsi_durasi">

                                                                                        <label for="{{$paket[$i]->id.'-1'}}">
                                                                                            Per-6 Bulan
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="{{$warna[$i]}} d-inline">
                                                                                        <input type="radio" id="{{$paket[$i]->id.'-2'}}"
                                                                                            data-paketid="{{ $paket[$i]->id }}"
                                                                                            data-paket="{{ 'Paket-'.$paket[$i]->name }}"
                                                                                            data-harga="{{$paket[$i]->biaya*12}}"
                                                                                            value="12" name="opsi_durasi">

                                                                                        <label for="{{$paket[$i]->id.'-2'}}">
                                                                                            Per-12 Bulan
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-12 box-nilai-paket">
                                                                                <div class="d-flex pl-1 pr-1 justify-content-between">
                                                                                    Total Rp<span class="nilai-paket">{{rupiah($paket[$i]->biaya*12)}}</span>
                                                                                    <span class="durasi-paket align-self-center badge badge-light">/12-Bulan</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    @endfor
                                                </div>

                                                <div class="tab-footer bg-gradient-light">
                                                    <div class="row justify-content-between">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="ml-2">Catatan:</div>
                                                                <div class="col-11">
                                                                    <ul class="mb-1" style="padding-inline-start: 20px">
                                                                        <li class="p-0">
                                                                            Trx.Sale (Transaksi Penjualan).
                                                                        </li>
                                                                        <li class="p-0">
                                                                            Discount Paket berlaku selama periode tertentu, sewaktu-waktu bisa berubah.
                                                                        </li>
                                                                    </ul>

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!--pakets-->

                                        </div><!--tab-content-->
                                    </div><!--card-body-->
                                </div><!--card-->
                                <div class="row pt-0 pl-2 pr-2 pb-2">
                                    <div class="row form-errors justify-content-center"></div>
                                </div>
                            </div><!--cols-2-->

                        </div><!--row-->
                    </div><!--card-body-->

                    <div id="progress_animation" class="overlay dark align-content-center" style="display: none">
                        <div class="col-md-3 col-sm-6 col-12">
                            <div class="info-box" id="progress-box">
                                <span class="info-box-icon">
                                    <i class="loading"></i>
                                    <span id="percent_bar" class="absolute" style="font-size: 17px">0%</span>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-number" id="title_progress">Mohon Menunggu</span>
                                    <span class="info-box-text" id="status_progress">Sedang Proses Persiapan Toko...</span>
                                </div>
                            </div>
                        </div>
                    </div><!--progress-bar-->

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

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{config('services.midtrans.serverKey')}}"></script>
@endsection

{{-- <div class="col-md-5">
    <form id="form_user_access">
        @csrf
        <div class="card card-info card-outline">
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
                        <div class="form-group">
                            <label class="col-form-label" for="username">Username / Kode</label>
                            <input type="text" name="username" class="form-control form-control-border" id="username" autocomplete="off"  value="{{Auth::user()->username}}" disabled>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="col-form-label" for="email">E-mail</label>
                            <input type="email" name="email" class="form-control form-control-border" id="email"  value="{{$usaha->email}}" disabled>
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
    </form>
</div> --}}
