@extends('ui_admin.layouts.main')

@section('token')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title','Transaksi - Pembelian')

@section('css-x')
    <!-- This Page -->
    <link rel="stylesheet" href="{{ asset('custom/css/style.css')}}">
    <style>
        table .form-control {
            font-size: 16px;
        }
    </style>
@endsection

@section('topjs-x')
    {{-- <script>
        const beforeUnloadListener = (event) => {
            event.preventDefault();
            return event.returnValue = 'Are you sure you want to exit?';
        };

        // A function that invokes a callback when the page has unsaved changes.
        onPageHasUnsavedChanges(() => {
            addEventListener('beforeunload', beforeUnloadListener, {capture: true});
        });

        // A function that invokes a callback when the page's unsaved changes are resolved.
        onAllChangesSaved(() => {
            removeEventListener('beforeunload', beforeUnloadListener, {capture: true});
        });
    </script> --}}

    {{-- <script type="text/javascript">
        const beforeUnloadListener = (e) => {
            e.preventDefault();
            return e.returnValue = "Are you sure you want to exit?";
        };

        const nameInput = document.querySelector("#code_item");
        nameInput.addEventListener("input", (e) => {
            if (e.target.value !== "") {
                console.log(e.target.value);
                addEventListener("beforeunload", beforeUnloadListener, {capture: true});
            } else {
                removeEventListener("beforeunload", beforeUnloadListener, {capture: true});
            }
        });
    </script> --}}

    {{-- <script type="text/javascript">
        window.onbeforeunload = function(e) {
            return "Changes you made may not be saved.";
        }
    </script> --}}
@endsection

@php
    function rupiah($angka){
        // $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,',',',');
        return $hasil_rupiah;
    };

    $hariIni = \Carbon\Carbon::now()->locale('id');
@endphp

@section('content')
    <div class="content pt-2 pb-2">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title text-bold">Transaksi Pembelian</h3>
                        <div class="card-tools">
                            <button type="button" name="btn-nota-baru" class="btn btn-sm btn-primary">F2 - Buat Nota Baru</button>
                            <button type="button" name="btn-list-nota" class="btn btn-sm btn-info" data-toggle="modal"
                                data-target="#daftar-Nota">F4 - Daftar Transaksi</button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                        </div>
                    </div>
                    <div class="card-body" style="padding:10px;">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Form Pembelian</h3>
                                    </div>
                                    {{-- Form Pembelian --}}
                                    <form id="form_isian">
                                        <div class="card-body" style="display: block;">
                                            <div class="row">
                                                <div class="col-sm-8">
                                                    <div class="form-group">
                                                        {{-- <label>Kode Barang</label>
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <input type="text" name="code_item" id="code_item" class="form-control form-control-sm" maxlength="13">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <button type="button" name="cari_barang" id="cari_barang" class="btn btn-sm btn-info" disabled>Cari Barang</button>
                                                            </div>
                                                        </div> --}}

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
                                            </div>
                                            {{-- Posisi Tabel Bantu Cari Barang --}}
                                            <div class="form-group">
                                                <label>Nama Barang</label>
                                                <input type="text" name="nama_item" id="nama_item" class="form-control form-control-sm" disabled>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Harga</label>
                                                        <input type="text" class="form-control form-control-sm rupiah text-right" name="hrg_beli" id="hrg_beli">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Satuan</label>
                                                        <select class="form-control form-control-sm select2" style="width: 100%" name="satuan" id="satuan" aria-readonly="true">
                                                            @foreach ($satuan as $item)
                                                                @if ($item->konversi == 0)
                                                                    <option value="{{ $item->tipe }}">{{ $item->tipe }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>QTY</label>
                                                        <div class="input-group input-group-sm">
                                                            <input type="number" name="qty" class="form-control form-control-sm">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text" id="label_satuan"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Total</label>
                                                        <input type="text" name="total_harga" class="form-control form-control-sm text-right rupiah" readonly>
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
                                <div class="card card-primary card-outline shadow">
                                    <form id="nota_pembelian">
                                        {{-- <div id="method"></div> --}}
                                        @csrf
                                        <div class="card-header" style="margin-bottom: 5px">
                                            <div class="row">
                                                <table style="width: 100%" id="nota_head">
                                                    <thead>
                                                        <th style="width: 15%">Nomor Nota</th>
                                                        <th style="width: 15%">Tanggal</th>
                                                        <th style="width: 10%"></th>
                                                        <th style="width: 15%">Supplier</th>
                                                        <th style="width: 8%" class="text-right">Alamat :</th>
                                                        <th style="width: 37%; font-weight: normal">
                                                            <span class="text-blue" id="alamat">...</span>
                                                        </th>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="nomor_nota"
                                                                class="form-control form-control-sm text-bold text-lg-center"
                                                                placeholder="NB.00000001" readonly>
                                                            </td>
                                                            <td>
                                                                <input
                                                                    type="text"
                                                                    data-inputmask-alias="date"
                                                                    data-inputmask-inputformat="dd-mm-yyyy"
                                                                    im-insert="false" placeholder="dd-mm-yyyy"
                                                                    class="form-control form-control-sm text-center datemask"
                                                                    name="tanggal" value="{{ $hariIni->format('d-m-Y') }}" >
                                                                {{-- <input
                                                                    type="text"
                                                                    class="form-control form-control-sm text-center datemask"
                                                                    name="tanggal" value="{{ $hariIni->format('d-m-Y') }}"> --}}
                                                            </td>

                                                            {{-- Kassa/Kasir --}}
                                                            <td></td>

                                                            <td>
                                                                <select name="supplier" id="supplier" class="form-control-sm select2" style="width: 100%;">
                                                                    @foreach ($supplier as $value)
                                                                        @if ($value->status == 1)
                                                                            <option data-alamat="{{$value->alamat}}" data-kota="{{$value->kota}}" data-telp="{{$value->telpon}}" value='{{$value->id}}'> {{$value->nama}} </option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td class="text-bold text-right">Kota : </td>
                                                            <td class="text-blue" id="kota">...</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4"></td>
                                                            <td class="text-bold text-right">Telpon : </td>
                                                            <td class="text-blue" id="telpon">...</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        {{-- tabel data --}}
                                        <div class="card-body table-responsive pt-0 pr-1 pl-1 pb-1" style="height: 400px;">
                                            <table class="table table-bordered table-hover table-head-fixed" id="tabel_rinci">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th style="width: 5%">No</th>
                                                        <th style="width: 10%">Kode Barang</th>
                                                        <th>Nama Barang</th>
                                                        <th style="width: 15%">Harga</th>
                                                        <th style="width: 15%">QTY</th>
                                                        <th style="width: 13%">Jumlah</th>
                                                    </tr>
                                                </thead>
                                                {{-- isian rincian data --}}
                                                <tbody></tbody>

                                            </table>
                                        </div>

                                        {{-- button action & input bayar--}}
                                        <div class="card-footer nota" id="inputBayar">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="row mt-1 mb-1">
                                                        <button type="button" name="btn-bayar" class="btn btn-sm btn-warning mr-1">F8-Pembayaran</button>
                                                        <button type="button" name="btn-simpan" class="btn btn-sm btn-success mr-1">F9-Simpan</button>
                                                        <button type="reset" name="btn-batal" class="btn btn-sm btn-danger mr-1">F10-Batal</button>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="">
                                                        Total Item : <span id="total_item" class="text-bold">0</span>
                                                    </div>
                                                    <div id="selisih_ket">Selisih Bayar :</div>
                                                    <span id="total_selisih" class="text-bold">0</span>
                                                </div>

                                                <div class="col-md-3">
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

                                                <div class="col-md-3">
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
                                                                        <input class="form-control text-right text-red rupiah" type="text" name="discount" value="0">
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:50%"><b>Total Rp</b></td>
                                                                    <td>
                                                                        <input class="form-control text-right text-bold rupiah" type="text" name="grandTotal" value="0">
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
                        <h5 class="modal-title" id="daftar-notaTitle">Daftar Nota Pembelian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body ">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group row">
                                    <label for="tgl_periode" class="col-md-3 text-sm mb-0 align-self-center">Tanggal Periode:</label>
                                    <div class="col-md-4">
                                        <input type="text" data-inputmask-alias="date" data-inputmask-inputformat="dd-mm-yyyy"
                                            im-insert="false" placeholder="dd-mm-yyyy"
                                            class="form-control form-control-sm text-center text-sm datemask-2"
                                            id="tgl_periode" name="tgl_periode" value="{{ $hariIni->format('d-m-Y') }}" >
                                    </div>
                                    <div class="col-md-2 text-sm align-self-center" id="label_range">...</div>
                                </div>

                                <div class="row col-12 table-responsive" style="height: 350px;font-size:14px">
                                    <table class="table table-sm table-bordered table-hover table-head-fixed  mb-0" id="tabel_nota">
                                        <thead class="text-center">
                                            <th>#No</th>
                                            <th>Nomor Nota</th>
                                            <th>Tanggal</th>
                                            <th>Jumlah</th>
                                            <th>Supplier</th>
                                            <th>OPR. User</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-md-3 text-sm">
                                <table class="table table-bordered">
                                    <tr class="bg-green"><td colspan="2" class="text-center">Rekap Nota Pembelian</td></tr>
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
                                        <td>Total</td><td class="text-right text-bold" style="width:60%" id="total_nota_info">0</td>
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
                                        <label class="custom-control-label" for="customSwitch1">Tampilkan Nota Hapus</label>
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

    </div>
    <!-- /.content -->
@endsection

@section('js-x')
    <script>
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

    <script src="{{ asset('custom/js/transaction/pembelian.js')}}"></script>
@endsection
