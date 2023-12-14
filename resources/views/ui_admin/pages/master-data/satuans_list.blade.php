@extends('ui_admin.layouts.main')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title')
    Master Data - Satuan Barang
@endsection

@section('title-page')
    <i class="fas fa-house-user"></i>
    Data Satuan Barang
@endsection

@section('css-x')
    <style>
        span.no-card:hover {
            cursor: pointer;
        }
        .selected-card {
            background-color:bisque !important;
        }
        .card.bg-box:hover {
            background-color:rgba(221, 221, 221, 0.548) !important;
        }
    </style>
@endsection

@php
    $satuanB = ['BALL','CTN','DRUM','DUS','KRG','ZAK'];
    $satuanS = ['BOX','TIM','KRAT','KTK','KG','SLOP','JRGN','IKAT','PACK','PAIRS','PAIL'];
    $satuanK = ['PCS','BKS','BLEK','LBR','KG','KLG','RTG','PACK'];
@endphp

@section('content')
    <div class="content pt-2 pb-2">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-info card-outline mb-0">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-address-card"></i> Form dan Daftar Satuan Barang</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Fullscreen" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                        </div>
                    </div>
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card card-info shadow">
                                    <div class="card-header">
                                        <h3 class="card-title">Form Satuan Barang</h3>
                                    </div>

                                    <form class="form-horizontal" id="form_satuan">
                                        <div class="card-body" style="font-size: 14px;line-height: 16px">
                                            <div class="form-errors"></div>
                                            <div class="form-group">
                                                <label for="konversi" class="col-form-label">Keterangan:</label>
                                                <dd><b>1. Satuan Tunggal (tanpa konversi)</b></dd>
                                                <ol>
                                                    <li>Pilih Jenis Satuan <b>Tunggal</b>, lalu pilih salah satu
                                                        jenis satuan (besar, sedang atau kecil).
                                                    </li>
                                                    <li>
                                                        Jenis satuan ini digunakan untuk barang yang
                                                        dijual dalam <b><u>Satu Jenis satuan.</u></b>
                                                    </li>
                                                </ol>
                                                <dd><b>2. Satuan Konversi</b></dd>
                                                <ol>
                                                    <li>Pilih Jenis Satuan <b>Konversi</b>, lalu Pilih 2 s/d 3 jenis satuan
                                                        (besar/sedang dan kecil (wajib)</li>
                                                    <li>Jenis satuan ini digunakan untuk barang yang dijual dalam
                                                        <b> <u>Banyak Jenis Satuan</u></b>
                                                    </li>
                                                </ol>
                                            </div>

                                            <div class="form-group row justify-content-center">
                                                <div class="col-sm-4">
                                                    <label>#-Pilih Jenis Satuan:</label>
                                                </div>
                                                <div class="col-sm-8">
                                                        <!-- radio -->
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" class="form-control" name="jenis_satuan" value="0" id="jenis_tunggal" checked="checked">
                                                            <label for="jenis_tunggal">Tunggal</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" class="form-control" name="jenis_satuan" value="1" id="jenis_konversi">
                                                            <label for="jenis_konversi">Konversi</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <table class="table table-sm table-head-fixed text-nowrap table-bordered" id="table_form">
                                                    <thead class="text-center">
                                                        <tr>
                                                            <th colspan="2" rowspan="2">Satuan</th>
                                                            <th colspan="2" class="text-center">Konversi</th>
                                                        </tr>
                                                        <tr>
                                                            <th style="max-width: 10%">Nilai/Qty</th>
                                                            <th style="max-width: 15%">Harga</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>1
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" class="form-control" name="check_satuan[]" id="satuan_b_check" value="B">
                                                                    <label for="satuan_b_check">Besar</label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <select class="form-control-sm select2" name="pilih_satuan_b" style="width: 100%">
                                                                    @foreach ($satuanB as $value)
                                                                        <option value={{$value}}>{{$value}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="number" name="inp_nilai[]" value="100" class="form-control form-control-sm mr-2" id="nil_satuan_b">
                                                                    <span id="satuan_kecil">PCS</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="inp_harga[]" value="0" class="form-control form-control-sm mr-2 rupiah" id="hrg_satuan_b">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>2
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" class="form-control" name="check_satuan[]" id="satuan_s_check" value="S">
                                                                    <label for="satuan_s_check">Sedang</label>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <select class="form-control-sm select2" name="pilih_satuan_s" style="width: 100%">
                                                                    @foreach ($satuanS as $value)
                                                                        <option value={{$value}}>{{$value}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="number" name="inp_nilai[]" value="50" class="form-control form-control-sm mr-2" id="nil_satuan_s">
                                                                    <span id="satuan_kecil">PCS</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="inp_harga[]" value="0" class="form-control form-control-sm mr-2 rupiah" id="hrg_satuan_s">
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>3
                                                                <div class="icheck-primary d-inline">
                                                                    <input type="checkbox" class="form-control" name="check_satuan[]" id="satuan_k_check" value="K">
                                                                    <label for="satuan_k_check">Kecil</label>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <select class="form-control-sm select2" name="pilih_satuan_k" style="width: 100%">
                                                                    @foreach ($satuanK as $value)
                                                                        <option value={{$value}}>{{$value}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <input type="number" name="inp_nilai[]" value="1" class="form-control form-control-sm mr-2" id="nil_satuan_k">
                                                                    <span id="satuan_kecil">PCS</span>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="inp_harga[]" value="0" class="form-control form-control-sm mr-2 rupiah" id="hrg_satuan_k">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="kode_satuan" class="col-form-label">Kode Satuan</label>
                                                        <input type="text" class="form-control text-center" name="kode_satuan" id="kode_satuan" placeholder="-">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="nilai_satuan" class="col-form-label">Nilai Satuan</label>
                                                        <input type="text" class="form-control text-center" name="nilai_satuan" id="nilai_satuan" placeholder="-">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="card-footer text-center">
                                            <button class="btn btn-sm btn-primary" type="button" id="btn_add">Tambah</button>
                                            <span id="btn_action"></span>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="col-lg-9">
                                <div class="card card-info shadow-sm">
                                    <div class="card-header">
                                        <h3 class="card-title">Daftar Satuan Barang</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" id="refresh" data-card-widget="card-refresh" data-source="#" data-source-selector="#card-refresh-content">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" id="view-tabel">
                                                <i class="fas fa-list-alt"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" id="view-card">
                                                <i class="fas fa-th"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body table-responsive p-0" style="height: 680px; ">
                                        <div class="row mt-2 ml-0 mr-0 justify-content-center" id="card-satuan"></div>
                                        <table class="table table-sm table-head-fixed table-bordered table-hover" id="table_satuan">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">#No</th>
                                                    <th class="text-center">Kode Satuan</th>
                                                    <th class="text-center">Nilai Konversi</th>
                                                    <th class="text-center">Konversi</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-x')
    <!-- InputMask -->
    <script src="{{ asset('ui_admin/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    {{-- jquery Foam --}}
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.form.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.validate.js') }}"></script>

    <Script>
        $(function (){
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        })
    </Script>
    <!-- page this -->
    <script src="{{ asset('custom/js/master-data/satuan.js')}}"></script>
@endsection
