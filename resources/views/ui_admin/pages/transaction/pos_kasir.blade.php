@extends('ui_admin.layouts.main')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title','Transaksi - POS(Kasir)')

@section('css-x')
    <!-- This Page -->
    <link rel="stylesheet" href="{{ asset('custom/css/style.css')}}">
    <style>
        .form-control {font-size: 16px !important}
        /* table#tabel_rinci, tr:hover{
            background-color: rgb(208, 252, 182) !important;
        } */
    </style>
@endsection

@section('topjs-x')
@endsection

@php
    function rupiah($angka){
        // $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,',',',');
        return $hasil_rupiah;
    };
    $hariIni = \Carbon\Carbon::now()->locale('id');
    $teks1 ="Selamat Datang di Toko Kami, Silahkan Berbelanja Keperluan Anda, Terima Kasih.";
    $teks2 ="................................................................";
@endphp

@section('content')
    <div class="content pt-2 pb-2">
        <div class="row">
            <div class="col-12">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-bold">Transaksi Penjualan (POS-Kasir)</h3>
                        <div class="card-tools">
                            <button type="button" name="btn-sesi-out" id="btn-sesi-out" class="btn btn-sm btn-warning" style="display: none">F12 - Keluar dari Sesi Saat Ini</button>
                            <button type="button" name="btn-nota-baru" class="btn btn-sm btn-primary">F2 - Nota Baru</button>
                            <button type="button" name="btn-list-nota" class="btn btn-sm btn-info" data-toggle="modal"
                                data-target="#daftar-Nota">F4 - Daftar Transaksi</button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                        </div>
                    </div>
                    <div class="card-body" style="padding:10px;">
                        {{-- layar Bantu --}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="small-box bg-success" style="width: 100%;height: 110px;">
                                    <div class="inner">
                                        <h3 id="nama_x">...</h3>
                                        <p style="font-size: 26px;margin:0">
                                            <span id="qty_x" class="text-bold">0 -</span><span id="harga_x" style="color: yellow">0</span>
                                        </p>
                                    </div>
                                    <div class="icon">
                                        <i style="transform: none" class="fas text-white" id="jml_x">0</i>
                                        <i style="transform: none" class="fas text-white" id="marquee">
                                            {{ $teks1 }} <span id="transparant">{{ $teks2 }}</span>
                                        </i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Form Penjualan --}}
                            <div class="col-lg-3">
                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Form Barang</h3>
                                    </div>

                                    <form id="form_isian">
                                        <div class="card-body" style="display: block;">
                                            <div class="row col-sm-8">
                                                <div class="form-group" >
                                                    <label>Kode Barang / Barcode</label>
                                                    <div class="input-group input-group-sm">
                                                        <input type="search" name="code_item" id="code_item"
                                                            class="form-control" maxlength="13"
                                                            data-toggle="tooltip" data-placement="top"
                                                            title="Tekan Sesuatu / <b>Panah Bawah</b> utk Munculkan <span class='text-bold text-yellow'>Daftar Barang</span>">
                                                        <div class="input-group-append"
                                                            data-toggle="tooltip" data-placement="right"
                                                            title="Cari <b>cepat</b> barang sesuai <em><b>kode</b></em>,  <span class='text-bold text-yellow'>jika kosong</span> akan dimunculkan <span class='text-bold text-yellow'>Daftar Barang</span>">
                                                            <button type="button" name="cari_barang" id="cari_barang" class="btn btn-info" disabled>
                                                                <i class="fa fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Nama Barang</label>
                                                <input type="text" name="nama_item" id="nama_item" class="form-control" disabled>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Harga</label>
                                                        <input type="text" class="form-control rupiah text-right" name="hrg_jual" id="hrg_jual">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Satuan</label>
                                                        <select class="form-control" style="width: 100%" name="satuan" id="satuan" aria-readonly="true">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>QTY</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" name="qty" id="qty" class="form-control">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text" id="label_satuan"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Total</label>
                                                        <input type="text" name="total_harga" id="total_harga" class="form-control text-right rupiah" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                            <button type="button" class="btn btn-sm btn-primary" id="tambah_item" disabled>Tambahkan Item</button>
                                            <span id="btn_action"></span>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            {{-- Rincian Barang --}}
                            <div class="col-lg-9">
                                <div class="card card-success card-outline shadow">
                                    <form id="nota_penjualan">
                                        @csrf
                                        <div class="card-header" style="margin-bottom: 5px">
                                            <div class="row">
                                                <table style="width: 100%" id="nota_head">
                                                    <thead>
                                                        <th style="width: 15%">Nomor Nota</th>
                                                        <th style="width: 10%">Tanggal</th>
                                                        <th style="width: 15%" class="justify-content-between">
                                                            Kassa# <span class="badge badge-info badge-pill" id="kassa_aktif">-</span>
                                                            <span class="badge badge-info badge-pill" id="shift_aktif">-</span>
                                                        </th>
                                                        <th style="width: 1%" ></th>
                                                        <th style="width: 20%" class="justify-content-between">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    Pelanggan
                                                                </div>
                                                                <div class="col-6 text-right btn-plgn">
                                                                    <i class="fas fa-sync-alt"></i>
                                                                    <i class="fas fa-plus"></i>
                                                                </div>
                                                            </div>
                                                        </th>
                                                        <th style="width: 8%" class="text-right">Alamat :</th>
                                                        <th style="font-weight: normal">
                                                            <span class="pl-2" id="alamat">...</span>
                                                        </th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            {{-- nota/tanggal --}}
                                                            <td>
                                                                <input type="text" name="nomor_nota"
                                                                class="form-control form-control-sm text-bold text-center text-md"
                                                                placeholder="NB.XXXXXX00001" readonly>
                                                            </td>
                                                            {{-- tanggal --}}
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm text-sm text-bold text-center"
                                                                    name="tanggal" value="{{ $hariIni->format('d-m-Y') }}" >
                                                                {{-- <input
                                                                    type="text"
                                                                    data-inputmask-alias="date"
                                                                    data-inputmask-inputformat="dd-mm-yyyy"
                                                                    im-insert="false" placeholder="dd-mm-yyyy"
                                                                    class="form-control form-control-sm text-center datemask"
                                                                    name="tanggal" value="{{ $hariIni->format('d-m-Y') }}" > --}}
                                                            </td>
                                                            {{-- Kassa/Kasir --}}
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm text-sm text-bold text-center" value="A/1-XXXX" name="kasir_now" disabled>
                                                            </td>
                                                            {{-- space 1 --}}
                                                            <td></td>
                                                            {{-- Supplier/Customer(User-Store) --}}
                                                            <td>
                                                                <select name="customer" id="customer" class="form-control form-control-sm select2" style="width: 100%;">
                                                                    @foreach ($customer as $value)
                                                                        {{-- @if ($value->active == 1) --}}
                                                                            <option data-alamat="{{$value->alamat}}" data-kota="{{$value->kota}}" data-telp="{{$value->telpon}}" value='{{$value->id}}'> {{$value->name}} </option>
                                                                        {{-- @endif --}}
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="text-bold text-right">Kota : </td>
                                                            <td class="pl-2" id="kota">...</td>
                                                        </tr>
                                                        {{-- Total Piutang, Telpon --}}
                                                        <tr>
                                                            <td colspan="4"></td>
                                                            <td class="justify-content-between">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <span class="text-sm pl-1">Tot.Piutang :</span>
                                                                    </div>
                                                                    <div class="col-6 text-right">
                                                                        <span class="badge-info badge-btn text-bold">12,500,000</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-bold text-right">Telpon : </td>
                                                            <td class="pl-2" id="telpon">...</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- tabel data --}}
                                        <div class="card-body table-responsive pt-0 pr-1 pl-1 pb-1" style="height: 360px;">
                                            <table class="table table-bordered table-hover table-head-fixed" id="tabel_rinci">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th style="width: 5%">No</th>
                                                        <th style="width: 15%">Kode Barang</th>
                                                        <th>Nama Barang</th>
                                                        <th style="width: 15%">Harga</th>
                                                        <th style="width: 15%">QTY</th>
                                                        <th style="width: 10%">Jumlah</th>
                                                    </tr>
                                                </thead>
                                                {{-- isian rincian data --}}
                                                <tbody></tbody>

                                            </table>
                                        </div>

                                        {{-- button action & input bayar--}}
                                        <div class="card-footer nota">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row mt-1 mb-1">
                                                        <button type="button" name="btn-bayar" class="btn btn-sm btn-warning mr-1">F8-Pembayaran</button>
                                                        <button type="button" name="btn-simpan" class="btn btn-sm btn-success mr-1">F9-Simpan</button>
                                                        <button type="reset" name="btn-batal" class="btn btn-sm btn-danger mr-1">F10-Batal</button>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="status">Pilihan Cetak:</label>
                                                        <div class="form-group clearfix">
                                                            <div class="icheck-primary d-inline">
                                                                <input type="checkbox" id="struk" name="struk" value="struk" checked>
                                                                <label for="struk">Cetak Struk</label>
                                                            </div>
                                                            <div class="icheck-primary d-inline">
                                                                <input type="checkbox" id="delivery" name="delivery" value="delivery">
                                                                <label for="delivery">Delevery Order</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="">
                                                        Total Item : <span id="total_item" class="text-bold">0</span>
                                                    </div>
                                                    <div class="">
                                                        Total Berat : <span id="total_berat" class="text-bold">0 Kg</span>
                                                    </div>
                                                    <div id="selisih_ket">Selisih Bayar :</div>
                                                    <span id="total_selisih" class="text-bold">0</span>
                                                </div>

                                                <div class="col-md-3 inputBayar">
                                                    <div class="row text-right">
                                                        <table class="table table-bordered" style="width: 100%" id="pembayaran">
                                                            <tbody class="text-left">
                                                                <tr>
                                                                    <td>
                                                                        <b>Tunai</b>
                                                                        <input class="form-control text-right rupiah" type="text" name="byrCash" id="byrCash">
                                                                    </td>
                                                                    <td>
                                                                        <b>D/C Card</b>
                                                                        <input class="form-control text-right rupiah" type="text" name="byrCard" id="byrCard">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <b>Kredit</b>
                                                                        <input class="form-control text-right rupiah" type="text" name="byrKredit" id="byrKredit">
                                                                    </td>
                                                                    <td>
                                                                        <b>Jatuh Tempo</b>
                                                                        <div class="row">
                                                                            <div class="col-sm-8">
                                                                                <input class="form-control text-left" id="tempo" type="text" name="lamaTempo" value="14" maxlength="2">
                                                                            </div>
                                                                            <div class="col-sm-4 text-left">Hari</div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                                <div class="col-md-3 inputBayar">
                                                    <div class="row text-right">
                                                        <table class="table table-bordered" style="width: 100%" id="total_nota">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width:50%"><b>Sub Total Rp</b></td>
                                                                    <td>
                                                                        <input class="form-control text-right rupiah" type="text" name="subTotal"  id="subTotal">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:50%"><b>Discount Rp</b></td>
                                                                    <td>
                                                                        <input class="form-control text-right text-red rupiah" type="text" name="discount" id="discount" value="0">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:50%"><b>Total Rp</b></td>
                                                                    <td>
                                                                        <input class="form-control text-right text-bold rupiah" type="text" name="grandTotal" id="grandTotal" value="0">
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
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
            </div>
        </div><!-- /.container-fluid -->

        {{-- Tabel Bantu Cari Barang --}}
        <div class="form-group" id="popup-item" tabindex="-1" style="display: none">
            <div class="card card-info card-info">
                <div class="card-header" style="margin-bottom: 5px; padding: 5px 20px">
                    <h3 class="card-title" style="padding:5px;font-size:16px">Daftar Barang</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="card-refresh" id="refresh"
                            data-toggle="tooltip" data-placement="top" title="Ambil Data <span class='text-bold text-yellow'>Terbaru</span> dari Database Server"
                            data-source="#" data-source-selector="#card-refresh-content" data-load-on-init="false">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <button type="button" class="btn btn-tool" id="tutup" data-card-widget="remove">
                            <i class="fas fa-times" tooltips="Close"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body table-responsive pt-0 pr-1 pl-1 pb-1" style="height: 350px;font-size:14px">
                    <table class="table table-bordered table-hover table-head-fixed" id="tabel_barang">
                        <thead class="text-center">
                            <th style="width:5%">Code</th>
                            <th>Nama</th>
                            <th style="width:22%">Satuan</th>
                            <th style="width:10%">Harga</th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="card-footer p-2" style="font-size:14px">
                    <b>Catatan : </b><div id="note_cari">Gunakan Mouse Klik, panah atas/bawah dan enter dan utk ambil barang</div>
                </div>
                <div class="overlay" id="loading" style="display: none">
                    <div class="loader">
                        <div class="loading"></div>
                        {{-- <span>12%</span> --}}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Daftar Nota -->
        <div class="modal fade" id="daftar-nota" tabindex="-1" role="dialog" aria-labelledby="daftar-notaTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-blue" style="margin-bottom: 5px">
                        <h5 class="modal-title" id="daftar-notaTitle">Daftar Nota Penjualan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="font-size: 14px !important">
                        <div class="row">
                            <div class="col-md-9">
                                <table style="height: 350px" class="table table-sm table-responsive table-bordered table-striped table-hover table-head-fixed m-0" id="tabel_nota">
                                    <thead class="text-center">
                                        <th style="width:2%">#No</th>
                                        <th style="width:10%">Nomor Nota</th>
                                        <th style="width:5%">Tanggal</th>
                                        <th style="width:5%">Jumlah</th>
                                        <th style="width:10%">Customer</th>
                                        <th style="width:10%">Kasir</th>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            <div class="col-md-3 p-0">
                                <table class="table table-bordered">
                                    <tr class="bg-green"><td colspan="2" class="text-center">Penjualan Hari ini</td></tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td class="text-center" style="width:60%" id="tgl_sesi_info">
                                            zz{{-- <input
                                            type="text"
                                            data-inputmask-alias="date"
                                            data-inputmask-inputformat="dd-mm-yyyy"
                                            im-insert="false" placeholder="dd-mm-yyyy"
                                            class="form-control form-control-sm text-center text-sm datemask"
                                            name="tgl_nota" value="{{ $hariIni->format('d-m-Y') }}" > --}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Kasir</td><td style="width:60%" id="kasir_sesi_info">...</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-center">
                                            #Kassa <span class="badge-info badge-pill" id="kassa_info"></span>
                                            ~ #Shift <span class="badge-info badge-pill" id="shift_info"></span>
                                        </td>
                                    </tr>
                                    <tr><td colspan="2" class="text-center text-bold">T O T A L</td></tr>
                                    <tr>
                                        <td>Tunai/Cash</td><td class="text-right" style="width:60%" id="byr_tunai_info">0</td>
                                    </tr>
                                    <tr>
                                        <td>D/C Card</td><td class="text-right" style="width:60%" id="byr_kartu_info">0</td>
                                    </tr>
                                    <tr>
                                        <td>Kredit</td><td class="text-right" style="width:60%" id="byr_kredit_info">0</td>
                                    </tr>
                                    <tr>
                                        <td>Discount</td><td class="text-right" style="width:60%" id="pot_disc_info">0</td>
                                    </tr>
                                    <tfoot>
                                        <td>Total</td><td class="text-right text-bold" style="width:60%" id="total_sesi_info">0</td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div class="container-fluid row">
                            <div class="col-sm-6">
                                <span class="badge badge-primary text-sm mr-1">Enter</span>Pilih Nota
                                <span class="badge badge-danger text-sm ml-2 mr-1">Delete</span>Hapus Nota
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                        {{-- checked="checked" --}}
                                        <label class="custom-control-label" for="customSwitch1">Tampilkan Nota di-Hapus</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 text-center">
                                <button type="button" class="btn btn-sm btn-success" id="pilih_nota">Pilih Nota</button>
                                <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Daftar Sesi Jual -->
        <div class="modal fade" id="modal_sesijual" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_sesijualTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-lightblue" style="margin-bottom: 5px">
                        <h5 class="modal-title" id="modal_sesijualTitle">Daftar Sesi Penjualan (Kasir)</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body" style="font-size: 14px !important">
                        <table  id="tabel_sesijual" style="height: 350px" class="table table-sm table-responsive table-bordered table-striped table-hover table-head-fixed m-0">
                            <thead class="text-center">
                                <th style="width:2%">#No</th>
                                <th style="width:5%">Kode Sesi</th>
                                <th style="width:5%">Tanggal</th>
                                <th style="width:5%">Kassa - Shift</th>
                                <th style="width:5%">Kasir</th>
                                <th style="width:10%">Jml. TRX</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <div class="container-fluid row">
                            <div class="col-sm-6">
                                <span class="badge badge-primary text-sm mr-1">Enter</span>Pilih
                                <span class="badge badge-danger text-sm ml-2 mr-1">Delete</span>Hapus
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                        {{-- checked="checked" --}}
                                        <label class="custom-control-label" for="customSwitch2">Tampilkan Sesi di-Hapus</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 text-center">
                                <button type="button" class="btn btn-sm btn-success" id="pilih_sesi">Pilih Sesi</button>
                                <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-sm btn-primary" id="sesi_baru">Sesi Baru</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Form Sesi Baru  -->
        <div class="modal fade" id="modal-sesi-baru" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal-sesi-baruTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-indigo" style="margin-bottom: 5px">
                        <h5 class="modal-title" id="modal-sesi-baruTitle">Sesi Penjualan Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body" style="font-size: 14px !important">
                        <form id="sesi_baru">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="kas-awal">Kode Sesi</label>
                                    <input type="text" class="form-control text-center text-sm" name="kode_sesi" id="kode_sesi" readonly>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="tgl-sesi">Tanggal</label>
                                    <input
                                        type="text"
                                        data-inputmask-alias="date"
                                        data-inputmask-inputformat="dd-mm-yyyy"
                                        im-insert="false" placeholder="dd-mm-yyyy"
                                        class="form-control form-control-sm text-center text-sm datemask"
                                        name="tgl_sesi" id="tgl_sesi" value="{{ $hariIni->format('d-m-Y') }}" >
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="kassa">Kassa#</label>
                                    <select class="form-control form-control-sm select2" style="width: 100%" name="kassa" id="kassa" aria-readonly="true">
                                        <option value="1" selected>1</option>
                                        @for ($i=2 ; $i < 10; $i++)
                                            <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="shift">Shift#</label>
                                    <select class="form-control form-control-sm select2" style="width: 100%" name="shift" id="shift" aria-readonly="true">
                                        <option value="P" selected>Pagi</option>
                                        <option value="S">Siang</option>
                                        <option value="M">Malam</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row justify-content-between">
                                <div class="form-group col-md-4">
                                    <label for="kasir">Kasir</label>
                                    <select class="form-control form-control-sm select2" style="width: 100%" name="kasir" id="kasir" aria-readonly="true">
                                        @foreach ($kasir as $k)
                                            <option value="{{$k->id}}">{{$k->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="kas-awal">Kas Awal</label>
                                    <input type="text" class="form-control rupiah text-right text-sm" name="kas" id="kas" value="0">
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-sm btn-primary mr-1" id="buat_sesi">Buat Sesi</button>
                        {{-- <button type="button" class="btn btn-sm btn-warning mr-1" id="play_sound">Play Sound</button> --}}
                        <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Batal</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- /.content -->
@endsection

@section('js-x')
    <script type="text/javascript">
        // jquery
        $(window).bind("beforeunload",function(event) {
            return "You have some unsaved changes";
        });
    </script>

    <!-- InputMask -->
    <script src="{{ asset('ui_admin/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    {{-- jquery Foam --}}
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.form.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.validate.js') }}"></script>

    <!-- this page script -->
    <script src="{{ asset('custom/js/myjs.js')}}"></script>
    <script src="{{ asset('custom/js/running-text.js')}}"></script>

    <script src="{{ asset('custom/js/transaction/penjualan.js')}}"></script>
@endsection
