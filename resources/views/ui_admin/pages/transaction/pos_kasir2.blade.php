@extends('ui_admin.layouts.main')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title','Transaksi - POS(Kasir)')

@section('title')
    Transaksi - POS(Kasir)
@endsection

@section('title-page')
    <i class="fas fa-cash-register"></i>
    Transaksi - POS(Kasir)
@endsection


@section('css-x')
    <!-- This Page -->
    <link rel="stylesheet" href="{{ asset('custom/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('custom/css/receipt.css')}}">
    <style>
        .form-control {font-size: 16px !important}
        i:hover {
            background-color: #28a745;
            cursor: pointer;
            border-radius: 4px;
            color: white;
        }

        table#tabel_rinci tr:focus,
        .selected-row {
            background-color: #28a745 !important;
            color: white;
        }

        table#tabel_rinci td:focus {
            background-color: #28a745;
            color: white;
        }

        #tabel_rinci:focus-visible {
            outline: auto 1px #28a745 !important;
        }

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
    // $today = date_format(\Carbon\Carbon::now(),"d/m/Y - H:i:s");
    $hariIni = \Carbon\Carbon::now();
    $teks1 ="Selamat Datang di Toko Kami, Silahkan Berbelanja Keperluan Anda, Terima Kasih.";
    $teks2 ="................................................................";
@endphp

@section('content')
    <div class="content pt-2 pb-2">
        <div class="row">
            <div class="col-12">
                <div class="card card-success card-outline mb-0">
                    <div class="card-header">
                        <h3 class="card-title text-bold"><i class="fas fa-cash-register"></i> Penjualan (POS-Kasir)</h3>
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
                                <div class="small-box bg-success mb-2" style="width: 100%;height: 110px;">
                                    <div class="inner">
                                        <h3 id="nama_x">...</h3>
                                        <p style="font-size: 26px;margin:0">
                                            <span id="qty_x" class="text-bold">0 - </span><span id="harga_x" style="color: yellow">0</span>
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
                            <div class="col-lg-2">
                                <!-- Kasir -->
                                <div class="card card-success card-outline">
                                    <div class="card-body pt-2 pl-2 pr-2 pb-0">
                                        <div class="form-group row mb-0">
                                            <label for="kassa" class="col-sm-4 col-form-label">Kassa#</label>
                                            <div class="col-sm-8">
                                                <span class="badge badge-warning badge-pill" id="kassa_aktif">-</span>
                                                <span class="badge badge-warning badge-pill" id="shift_aktif">-</span>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label for="tanggal" class="col-sm-4 col-form-label">Kasir</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm text-sm text-bold text-center" name="kasir_now" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Form Isian Item Vertical -->
                                <div class="card card-success card-outline">
                                    <form id="form_isian">
                                        <div class="card-body p-2">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Kode Barang / Barcode</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="search" name="code_item" id="code_item"
                                                                class="form-control" maxlength="13"
                                                                data-toggle="tooltip" data-placement="top"
                                                                title="Tekan Sesuatu / <b>Panah Bawah</b> utk Munculkan <span class='text-bold text-yellow'>Daftar Barang</span>">
                                                            <div class="input-group-append"
                                                                data-toggle="tooltip" data-placement="right"
                                                                title="Cari <b>cepat</b> barang sesuai <em><b>kode</b></em>,
                                                                    <span class='text-bold text-yellow'>jika kosong</span> akan dimunculkan
                                                                    <span class='text-bold text-yellow'>Daftar Barang</span>">
                                                                <button type="button" name="cari_barang" id="cari_barang" class="btn btn-info" disabled>
                                                                    <i class="fa fa-search"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Nama Barang</label>
                                                <input type="text" name="nama_item" id="nama_item" class="form-control" disabled>
                                            </div>

                                            <div class="row">
                                                <!-- Harga Jual -->
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label>Harga Jual</label>
                                                        <input type="text" class="form-control rupiah text-right" name="hrg_jual" id="hrg_jual">
                                                    </div>
                                                </div>
                                                <!-- Qty Satuan -->
                                                <div class="col-sm-7">
                                                    <div class="form-group">
                                                        <label>QTY</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" name="qty" id="qty" class="form-control">
                                                            <div class="input-group-append p-0" style="height: 31px">
                                                                <span class="input-group-text p-0" id="label_satuans">
                                                                    <select class="form-control form-control-sm p-0 text-sm"
                                                                        style="width: 100%; background: #ced4da;"
                                                                        name="satuan" id="satuan" aria-readonly="true">
                                                                    </select>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Disc (% > Rp) -->
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Disc (% > Rp)</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="text" name="disc_item" id="disc_item" class="form-control text-left rupiah">
                                                            <div class="input-group-append p-0" style="height: 31px">
                                                                <span class="input-group-text pt-0 pb-0 pl-1 pr-1" id="label_disc">Rp</span>
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
                                            <div class="row">
                                                <!-- Harga Modal -->
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control rupiah text-right" name="hrg_modal" id="hrg_modal" readonly>
                                                    </div>
                                                </div>
                                                <!-- Total Berat -->
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control decimal text-right" name="jml_berat" id="jml_berat" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer text-center">
                                            <button type="submit" class="btn btn-sm btn-outline-success" id="tambah_item" disabled>
                                                <i class="fas fa-plus-square"></i> Tambahkan Item
                                            </button>
                                            <span id="btn_action"></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Form nota_penjualan -->
                            <form id="nota_penjualan" style="display: contents">
                                @csrf

                                <!-- Tabel Rincian Item -->
                                <div class="col-lg-8 p-0">
                                    <div class="card card-success card-outline shadow mb-1">
                                        <!-- tabel rincian data -->
                                        <div class="card-body table-responsive p-2" style="height: 470px;">
                                            <table class="table table-bordered table-hover table-head-fixed" id="tabel_rinci">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th style="width: 5%">No</th>
                                                        <th style="width: 15%">Kode Barang</th>
                                                        <th>Nama Barang</th>
                                                        <th style="width: 15%">QTY</th>
                                                        <th style="width: 10%">Harga</th>
                                                        <th style="width: 10%">Disc</th>
                                                        <th style="width: 15%">Jumlah</th>
                                                    </tr>
                                                </thead>
                                                {{-- isian rincian data --}}
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        <!-- button action -->
                                        <div class="card-footer justify-content-between pt-2 pb-2 pl-3 pr-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <span class="badge badge-btn badge-danger">Hapus Item -> Delete</span>
                                                    <span class="badge badge-btn badge-warning">Edit Item/baris -> Enter</span>
                                                    <!-- Setting Item Sama -->
                                                    <div class="form-group clearfix mt-1">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="checkbox" id="setting" name="setting" value="setting" checked>
                                                            <label for="setting" class="text-sm">Satukan Item yang sama (harga dan satuan)</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Total Item -->
                                                <div class="col-md-3">
                                                    <div class="">
                                                        Total Item : <span id="total_item" class="text-bold">0</span>
                                                    </div>
                                                    <div class="">
                                                        Total Berat : <span class="text-bold total_berat">0 Kg</span>
                                                    </div>
                                                    <div id="selisih_ket">Selisih Bayar : </div>
                                                    <span id="total_selisih" class="text-bold">0</span>
                                                </div>
                                                <!-- Sub Total -->
                                                <div class="col-md-3 inputBayar">
                                                    <div class="row text-right">
                                                        <table class="table table-bordered mb-0" style="width: 100%" id="total_nota">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width:40%"><b>Sub Total</b></td>
                                                                    <td>
                                                                        <input class="form-control text-right rupiah" type="text" name="subTotal"  id="subTotal">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:40%"><b>Disc.(+)</b></td>
                                                                    <td>
                                                                        <input class="form-control text-right text-red rupiah" type="text" name="discount" id="discount" value="0">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:40%"><b>Total</b></td>
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
                                    </div>
                                </div>
                                <!-- Nomor Nota, Tanggal, Pembayaran -->
                                <div class="col-lg-2">
                                    <!-- Nota -->
                                    <div class="card card-success card-outline">
                                        <div class="card-body p-2 pb-0">
                                            <div class="form-group row mb-0">
                                                <label for="nomor_nota" class="col-sm-4 col-form-label">Nomor</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="nomor_nota" id="nomor_nota" class="form-control form-control-sm text-bold text-center text-md"
                                                        placeholder="NB.XXXXXX00001" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label for="tanggal" class="col-sm-4 col-form-label">Tanggal</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm text-sm text-bold text-center text-md"
                                                        name="tanggal" value="{{ $hariIni->format('d-M-Y') }}" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pelanggan -->
                                    <div class="card card-success card-outline">
                                        <div class="card-body p-2">
                                            <div class="row justify-content-between pl-2 pr-0 pt-0 pb-1">
                                                <label>Pelanggan</label>
                                                <div class="col-6 text-right btn-plgn">
                                                    <i class="fas fa-sync-alt p-1" data-toggle="tooltip" title="Reload Pelanggan" id="re_customer"></i>
                                                    <i class="fas fa-plus p-1 d-none" id="add_customer"></i>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <select name="customer" id="customer" class="form-control form-control-sm select2" style="width: 100%;">
                                                </select>
                                                <div class="row">
                                                    <div class="col-6 text-left">
                                                        <span class="text-sm p-1">Piutang Rp.</span>
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        <span class="badge-info badge-btn text-bold" id="piutang">0</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="justify-content-between p-2 text-sm d-none">
                                                <div class="row">
                                                    Alamat :
                                                    <div class="pl-2" id="alamat"></div>
                                                    <div class="pl-2" id="kota"></div>
                                                    <div class="pl-2" id="telpon"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pembayaran and saved transaction -->
                                    <div class="card card-success card-outline" id="pembayaran">
                                        <div class="card-header p-2 text-center">
                                            <div class="card-title text-bold text-md">Pembayaran</div>
                                            <div class="card-tools">
                                                <button type="button" name="btn-bayar" class="btn btn-xs btn-warning mr-2">F8 - Pembayaran</button>
                                            </div>
                                        </div>
                                        <div class="card-body p-2">
                                            <div class="inputBayar p-2">
                                                <div class="form-group row mb-0">
                                                    <label for="byrCash" class="col-sm-4 col-form-label-sm">Tunai</label>
                                                    <div class="col-sm-8">
                                                    <input class="form-control text-right rupiah" type="text" name="byrCash" id="byrCash">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <label for="byrCard" class="col-sm-4 col-form-label-sm">D/C Card</label>
                                                    <div class="col-sm-8">
                                                    <input class="form-control text-right rupiah" type="text" name="byrCard" id="byrCard">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <label for="byrKredit" class="col-sm-4 col-form-label-sm">Kredit</label>
                                                    <div class="col-sm-8">
                                                    <input class="form-control text-right rupiah" type="text" name="byrKredit" id="byrKredit">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0">
                                                    <label class="col-sm-4 col-form-label-sm" for="tempo">Tempo</label>
                                                    <div class="col-sm-8">
                                                        <div class="row col-sm-12">
                                                            <input class="col-sm-8 form-control form-control-sm text-right rupiah" type="number" name="lamaTempo" id="tempo">
                                                            <span class="align-self-center pl-1 text-sm">Hari</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="row justify-content-center">
                                                <button type="submit" name="btn-simpan" class="btn btn-xs btn-success mr-1">F9 - Simpan</button>
                                                <button type="reset" name="btn-batal" class="btn btn-xs btn-danger">F10 - Batal</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" id="btn-preview" class="btn btn-xs btn-success mr-1"><i class="fas fa-search"></i> Preview Struk Terakhir<br>di-Cetak</button>
                                    </div>
                                </div>
                            </form>
                            <!-- end Form nota_penjualan -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Bantu Cari Barang --}}
        <div class="form-group" id="popup-item" tabindex="-1" style="display: none">
            <div class="card card-info">
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
                    <b>Catatan : </b><div id="note_cari">Gunakan Mouse Klik, panah atas/bawah dan tombol enter</div>
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
                                            {{-- <input
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
                                {{-- <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch2">
                                        <label class="custom-control-label" for="customSwitch2">Tampilkan Sesi di-Hapus</label>
                                    </div>
                                </div> --}}
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

        <!-- Layar Preview Struk -->
        <div class="modal fade" id="modal-struk" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal-struk-Title" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-info pl-3 pr-3 pt-2 pb-2 mb-0">
                        <h5 class="modal-title" id="modal-struk-Title">Preview Sales Receipt</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- Struk Preview -->
                            <div class="col-md-12 table-responsive p-2" style="height:500px" >
                                <!-- Struk -->
                                <div class="PrintArea struk uk80 d-block" id="struk_receipt">
                                    <div class="col-12">
                                        <div class="row justify-content-between align-self-center mt-1">
                                            <div class="col-sm-3">
                                                <div class="text-center align-self-center">
                                                    <img src="" class="logo_struk" alt="logo" height="60" width="65">
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="address text-center align-self-center">
                                                    <p class="jln_usaha">alamat usaha</p>
                                                    <p class="kota_usaha">Kota -  Telp</p>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="m-1">
                                        <div class="d-flex justify-content-between title">
                                            <div class="col-sm-6 align-self-center text-center">
                                                <p class="text-lg">Sales Receipt</p>
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <p class="no_struk">No.#: -</p>
                                                <p class="tgl_struk">{{ $hariIni->format('d-m-Y - H:m') }}</p>
                                            </div>
                                        </div>
                                        <hr class="m-1">

                                        <div class="row mr-1">
                                            <div class="col-sm-2">
                                                <span>Kepada:</span>
                                            </div>
                                            <div class="col-sm-10">
                                                <p class="nama_cust">N a m a</p>
                                                <p class="kota_cust">Kota</p>
                                            </div>
                                        </div>

                                        <table class="table" id="tabel_struk">
                                            <thead class="text-center">
                                                <th colspan="2">URAIAN</th>
                                                <th >QTY</th>
                                                <th >JUMLAH</th>
                                            </thead>
                                            <tbody></tbody>
                                            <tfoot class="text-bold">
                                                <tr>
                                                    <td style="border-top: 1px solid !important;" colspan="2">Total Berat:</td>
                                                    <td style="border-top: 1px solid !important;" class="text-right">Sub Total</td>
                                                    <td style="border-top: 1px solid !important;" class="text-right strukTotal">0</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="total_berat">0</td>
                                                    <td class="text-right">Disc.+ </td>
                                                    <td class="text-right strukDisc">0</td>
                                                </tr>
                                                <tr><td colspan="3" class="text-right">Total</td> <td class="text-right strukGTotal">0</td> </tr>
                                                <tr>
                                                    <td class="text-right">Tunai:</td><td class="text-right StrukTunai">0</td>
                                                    <td class="text-right">D/C.Card:</td><td class="text-right strukCard">0</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Kredit:</td><td class="text-right StrukKredit">0</td>
                                                    <td class="text-right">Tempo:</td><td class="text-right strukTempo">0</td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <div class="text-center">Terimakasih Atas Kunjungan Anda</div>
                                    </div>
                                </div>
                                <!-- DO -->
                                <div class="PrintArea delivery uk80 d-block" id="struk_do">
                                    <div class="col-12">
                                        <div class="row justify-content-between align-self-center mt-1">
                                            <div class="col-sm-3">
                                                <div class="text-center align-self-center">
                                                    <img src="" class="logo_struk" alt="logo" height="60" width="65">
                                                </div>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="address text-center align-self-center">
                                                    <p class="jln_usaha">Alamat Usaha</p>
                                                    <p class="kota_usaha">Kota - Telpon</p>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="m-1">
                                        <div class="d-flex justify-content-between title">
                                            <div class="col-sm-6 align-self-center text-center">
                                                <p class="text-lg">Delivery Order</p>
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <p class="no_struk">No.#: -</p>
                                                <p class="tgl_struk"> {{ $hariIni->format('d-m-Y - H:m') }}</p>
                                            </div>
                                        </div>
                                        <hr class="m-1">

                                        <div class="row mr-1">
                                            <div class="col-sm-2">
                                                <span>Kepada:</span>
                                            </div>
                                            <div class="col-sm-10">
                                                <p class="nama_cust">N a m a</p>
                                                <p class="kota_cust">Kota</p>
                                            </div>
                                        </div>

                                        <table class="table p-1" id="tabel_do">
                                            <thead >
                                                <th colspan="2">URAIAN</th>
                                                <th class="text-center" style="width: 25%">JUMLAH</th>
                                            </thead>
                                            <tbody></tbody>
                                            <tfoot class="text-bold">
                                                <tr>
                                                    <td style="border-top: 1px solid !important; width:75%">
                                                        Total Berat: <span class="mr-3 total_berat">0 Kg</span>
                                                    </td>
                                                    <td class="col-4 text-right" style="border-top: 1px solid !important;">Total:</td>
                                                    <td style="border-top: 1px solid !important;" class="text-right strukGTotal">0</td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <div class="text-center">Terimakasih Atas Kunjungan Anda</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <div class="row col-12">
                            <div class="col-sm-9">
                                <div class="form-group text-sm">
                                    <label for="status">Pilihan Cetak:</label>
                                    <div class="form-group clearfix">
                                        <div class="icheck-primary d-inline pr-2">
                                            <input class="selPA" type="checkbox" id="struk" name="struk" value="struk" checked>
                                            <label for="struk">Cetak Struk</label>
                                        </div>
                                        <div class="icheck-primary d-inline">
                                            <input class="selPA" type="checkbox" id="delivery" name="delivery" value="delivery">
                                            <label for="delivery">Cetak DO</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 align-self-center">
                                <button type="button" class="btn btn-sm btn-outline-success mr-1" id="cetak_struk">
                                    <i class="fas fa-print"></i> Cetak
                                </button>
                            </div>
                        </div>
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

    <script src="{{ asset('custom/js/transaction/penjualan2.js')}}"></script>
    <script src="{{ asset('custom/js/jquery.PrintArea.js')}}"></script>
@endsection
