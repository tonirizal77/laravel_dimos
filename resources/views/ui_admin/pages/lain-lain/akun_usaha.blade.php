@extends('ui_admin.layouts.main')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    Akun Usaha/Toko - Aktivasi
@endsection

@section('title-page')
    <i class="fas fa-house-user"></i>
    Akun Usaha/Toko - Aktivasi
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
        .box-akun-logo-akun {
            background-color: #17a2b8;
            display: flex;
            padding: 10px;
            box-sizing: border-box;
            border-radius: 10px;
            justify-content: center;
        }
        .box-akun-logo-akun img {
            height: 150px;
            width: 180px;
            display: flex;
            box-sizing: border-box;
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
            $roles = 'Staff';
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
                                <div class="card shadow" id="card-akun">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-laptop"></i> Data Akun Usaha</h3>
                                    </div>
                                    <div class="card-body" id="box_akun"></div>
                                    <div id="action_paket"></div>
                                </div>
                            </div>

                            <div class="col-md-9">
                                <div class="card shadow-lg">
                                    <div class="card-header p-2">
                                        <ul class="nav nav-pills nav-compact">
                                            <li class="nav-item"><a class="nav-link active" href="#list-order" data-toggle="tab"><i class="fas fa-clinic-medical"></i> Transaksi Order Akun</a></li>
                                            <li class="nav-item" id="listpakets"><a class="nav-link" href="#pakets" data-toggle="tab" >Daftar Paket</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body table-responsive" >
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="list-order">
                                                {{-- Tabel Paket Aktif --}}
                                                <h5 class="text-left"><i class="text-info fas fa-clinic-medical"></i> Daftar Order Paket Akun</h5>
                                                <!-- Responsive -->
                                                <div class="table-responsive" style="max-height: 630px">
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
                                                                <th style="width: 15%">Payment</th>
                                                            </tr>
                                                        </thead>
                                                        {{-- isian rincian data --}}
                                                        <tbody>
                                                            <tr><td colspan="8" class="text-center">Data Order Belum Tersedia</td></tr>
                                                        </tbody>
                                                    </table>
                                                </div>
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
    <script src="{{ asset('custom/js/lain-lain/akun-usaha.js')}}"></script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{config('services.midtrans.serverKey')}}"></script>
@endsection
