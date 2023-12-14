@extends('ui_admin.layouts.main')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title','Data Products / Barang')

@section('title-page')
    <i class="nav-icon fas fa-clipboard-list"></i>
    Data Products / Barang
@endsection

@section('css-x')
    <!-- table-responsive custom -->
    {{-- <link rel="stylesheet" href="{{ asset('custom/css/responsive-table2.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('custom/css/style.css')}}">
    <style>
        .img_product {width: 100%;}
        .img-icons {
            width: 100px; height: auto;
        }
        ol li b{
            color: blue;
        }
        th.focus {
            cursor: pointer;
        }
        th.selected.desc::after {
            top: -4px;
            right: 4px;
            content: "\2193";
            position: absolute !important;
            color: #17a2b8;
        }
        th.selected.asc::before {
            top: -4px;
            right: 4px;
            content: "\2191";
            position: absolute !important;
            color: #17a2b8;
        }
    </style>
@endsection

@php
    function rupiah($angka){
        // $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,',',',');
        return $hasil_rupiah;
    }
@endphp

@section('content')
    <!-- Main content -->
    <div class="content pt-2 pb-2">
        <div class="container-fluid p-0">
            <div class="card card-info card-outline mb-0">
                <div class="card-header">
                    <div class="card-title text-info text-bold">
                        {{-- <i class="nav-icon fas fa-clipboard-list"></i> Daftar Products / Barang --}}
                        <div class="row align-items-center text-md">
                            <label for="show_perpage" class="pr-3">Tampilkan :</label>
                            <div class="form-group row">
                                <select name="show_perpage" id="show_perpage" class="custom-select custom-select-sm form-control form-control-sm" style="width: 100%">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            <label for="show_perpage" class="pl-3">Data</label>
                        </div>
                    </div>

                    <div class="card-tools">

                        <div class="btn btn-tool">
                            <div class="row">
                                <div class="input-group input-group-sm">
                                    <label for="filter_data" class="col-md-4 text-right mb-0 text-secondary align-self-center">Filter Product :</label>
                                    <input type="search" name="filter_product" id="filter_product" class="form-control form-control-sm">
                                    <div class="input-group-append" id="btn_group">
                                        <button type="button" id="filter_barang" class="btn btn-info"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Filter Data">
                                            <i class="fa fa-search"></i>
                                        </button>
                                        <button type="button" id="filter_hapus" class="btn btn-danger"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Hapus Filter Data">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button type="button" class="btn btn-warning" data-card-widget="card-refresh" id="refresh"
                                            data-toggle="tooltip" data-placement="top"
                                            title="Ambil Data <span class='text-bold text-yellow'>Terbaru</span> dari Database Server"
                                            data-source="#" data-source-selector="#card-refresh-content" data-load-on-init="false">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-outline-info btn-sm" id="btn_add_data">
                            <i class="fas fa-plus-square"></i> Tambah Product
                        </button>
                        <button type="button" name="btn_edit_data" class="btn btn-sm btn-outline-warning" id="btn_edit">
                            <i class="fas fa-edit"></i> Edit Data
                        </button>
                        <button type="button" name="btn_hapus_data" class="btn btn-sm btn-outline-danger" id="btn_hapus">
                            <i class="fas fa-times"></i> Hapus Data
                        </button>

                        <button type="button" data-toggle="tooltip" data-title="Full Screen" class="btn btn-tool" data-card-widget="maximize">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body p-0 table-responsive" style="height: 680px">
                    <table id="tabel_products" class="table table-bordered table-hover table-head-fixed">
                        <thead>
                            <tr class="text-center">
                                {{-- <th style="width: 3%">No</th>
                                <th style="width: 8%">Code / Barcode</th>
                                <th>Nama Barang</th>
                                <th style="width: 10%">Kategori</th>
                                <th style="width: 5%">Konversi</th>
                                <th style="width: 10%">Harga Beli</th>
                                <th style="width: 10%">Harga Jual</th>
                                <th style="width: 10%">Stock Awal</th>
                                <th style="width: 10%">Stock Akhir</th> --}}
                                <th>No</th>
                                <th>Code / Barcode</th>
                                <th class="selected asc">Nama Barang</th>
                                <th>Kategori</th>
                                <th>Konversi</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Stock Awal</th>
                                <th>Stock Akhir</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

                <div class="overlay dark" style="display: none">
                    <i class="fas fa-2x fa-sync-alt"></i>
                </div>

                <div class="card-footer">
                    <div class="row justify-content-between">


                        <div class="row justify-content-between">
                            <div class="p-2">
                                Total Data : <span id="tot_rec" class="text-info">0</span> Baris
                            </div>
                            <div class="btn-group btn-group-sm" id="btn_navigate">
                                <button type="button" class="btn btn-info btn-xs" id="awal">
                                    <i class="fas fa-step-backward"></i> Awal
                                </button>
                                <button type="button" class="btn btn-info btn-xs" id="prev">
                                    <i class="fas fa-backward"></i> Prev
                                </button>
                                <button type="button" class="btn btn-info btn-xs" id="next">
                                    <i class="fas fa-forward"></i> Next
                                </button>
                                <button type="button" class="btn btn-info btn-xs" id="akhir">
                                    <i class="fas fa-step-forward"></i> Akhir
                                </button>
                            </div>
                        </div>

                        <div class="d-flex">
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item"><a class="page-link" href="#">«</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">»</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
    <!-- Modal Form Isian Data -->
    <div class="modal fade" id="modal_form_product" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_form_productTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-info" style="margin-bottom: 5px">
                    <h5 class="modal-title" id="modal_form_productTitle">
                        <i class="fas fa-house-user"></i> Form Isian Data Product
                    </h5>
                    <span class="info-aksi"></span>
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                </div>

                <div class="modal-body" style="font-size: 14px !important">
                    <div class="form-errors row"></div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-4 col-sm-12 align-self-center">
                                    <div class="justify-content-center">
                                        <div class="custom-upload-file text-center">
                                            <h5><i class="fas fa-camera"></i> Foto Product</h5>
                                            <label for="inputFile">
                                                <div class="box-img-product">
                                                    <img id="previewImg" src="{{asset('custom/gambar/gambar_product.png')}}" alt="Product">
                                                </div>
                                            </label>
                                        </div>

                                        {{-- <div class="custom-upload-file text-center">
                                            <!-- Ganti Gambar -->
                                            <form id="form_upload_gambar" enctype="multipart/form-data">
                                                <div id="method2">method2</div>
                                                @csrf
                                                <input type="file" class="btn btn-outline-info btn-xs" name="gambar" id="upload_gambar">
                                                <label for="upload_gambar" class="btn btn-outline-info btn-xs" id="label_upload">
                                                    <i class="fas fa-edit"></i> Ganti Gambar
                                                </label>
                                                <span id="btn_action_upload"></span>
                                            </form>
                                        </div> --}}

                                    </div>
                                </div>

                                <div class="col-lg-8 col-sm-12">
                                    <div class="card card-info card-outline">
                                        <form id="form_product" enctype="multipart/form-data">
                                            <div id="method"></div>
                                            @csrf
                                            <div class="card-header">
                                                <div class="card-title text-info"><i class="fas fa-house-user"></i> Form Product / Barang</div>
                                                <div class="card-tools">
                                                    <span id="btn_action"></span>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="alert alert-danger print-error-msg" style="display:none">
                                                        <ul></ul>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="row custom-upload-file">
                                                        <input type="file" name="gambar" id="inputFile" disabled/>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <!-- text input -->
                                                        <div class="form-group">
                                                            <label>Code / Barcode</label>
                                                            <input type="text" class="form-control form-control-border code" name="code" id="code" maxlength="13">

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="form-group">
                                                            <label>Nama Barang</label>
                                                            <input type="text" class="form-control form-control-border" name="nama_barang">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-5">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="satuan_konversi">Satuan Konversi</label>
                                                            <select class="form-control form-control-sm select2" style="width: 100%" name="satuan_konversi">
                                                                <option data-nilai="" value="" selected>Tidak Ada</option>
                                                                @foreach ($satuan as $value)
                                                                    @php
                                                                        $tipe = explode('-',$value->tipe)
                                                                    @endphp
                                                                    @if ($value->konversi == 1)
                                                                        <option data-nilai="{{$value->nilai}}" value="{{ $value->tipe }}">{{ $value->tipe }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="nilai_konversi">Nilai Konversi</label>
                                                            <input type="text" class="form-control form-control-border" id="nilai_konversi" name="nilai_konversi">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <!-- textarea -->
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="kategori">Kategori</label>
                                                            <select class="form-control form-control-sm select2" style="width: 100%" name="kategori">
                                                                @foreach ($kategori as $value)
                                                                    <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <!-- textarea -->
                                                        <div class="form-group">
                                                            <label>Keterangan</label>
                                                            <textarea class="form-control form-control-border" rows="2" placeholder="Keterangan..." name="keterangan"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label>Refresh Satuan & Kategori</label>
                                                            <button type="button" class="btn btn-outline-warning btn-xs" id="btn_reload"
                                                                data-toggle="tooltip" data-title="Jika tidak ada, Ambil Data Satuan & Kategori Terbaru dari Database">
                                                                <i class="fas fa-sync-alt"></i> Refresh
                                                            </button>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="satuan_beli">Satuan Beli</label>
                                                            <select class="form-control form-control-sm select2" style="width: 100%" name="satuan_beli">
                                                                @foreach ($satuan as $value)
                                                                    @if ($value->konversi == 0)
                                                                        <option value="{{ $value->tipe }}">{{ $value->tipe }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="hrg_beli">Harga Beli</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control form-control-border rupiah" id="hrg_beli" placeholder="0" name="hrg_beli">
                                                                <div class="input-group-append">
                                                                  <span class="input-group-text hrg_beli">/CTN</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="stock_aw">Stock Awal</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control form-control-border rupiah" id="stock_aw" placeholder="0" name="stock_aw">
                                                                <div class="input-group-append">
                                                                  <span class="input-group-text stock_aw">CTN</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="satuan_jual">Satuan Jual</label>
                                                            <select class="form-control form-control-sm select2" style="width: 100%" name="satuan_jual">
                                                                @foreach ($satuan as $value)
                                                                    @if ($value->konversi == 0)
                                                                        <option value="{{ $value->tipe }}">{{ $value->tipe }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="hrg_modal">Harga Modal</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control form-control-border rupiah" id="hrg_modal" placeholder="0" name="hrg_modal">
                                                                <div class="input-group-append">
                                                                  <span class="input-group-text hrg_modal">/CTN</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="hrg_jual">Harga Jual</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control form-control-border rupiah" id="hrg_jual" placeholder="0" name="hrg_jual">
                                                                <div class="input-group-append">
                                                                  <span class="input-group-text hrg_jual">/CTN</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="berat_satuan" class="col-form-label">Berat Satuan</label>
                                                            <div class="input-group input-group-sm">
                                                                <input type="text" class="form-control form-control-border text-right decimal"
                                                                    id="berat_satuan" placeholder="0" name="berat_satuan"
                                                                    inputmode="numeric">
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text berat_satuan">KG/?</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 align-self-baseline">
                                                        <label for="berat_satuan" class="col-form-label">Keterangan :</label>
                                                        <div class="form-group">
                                                            Berat Satuan dihitung dari satuan jual terkecil sebagai dasar hitungannya. Jika ada konversi diproses otomatis
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Keterangan --}}
                        <div class="col-lg-4">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <div class="card-title text-info"><i class="fas fa-address-book"></i> Keterangan</div>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="text-sm text-justify">
                                        <ol style="padding-inline-start: 20px;">
                                            <li>Gunakan <b>Code</b> utk merancang kode product sendiri (min. 6-7)
                                                karakter, atau gunakan <b>Barcode</b> yg terdapat pada label product
                                                yang sudah ada, pada umumnya terdiri dari 13 karakter (EAN-13).
                                            </li>
                                            <li>
                                                <b>Satuan Konversi,</b> satuan product yang memiliki lebih dari
                                                satu jenis satuan barang dalam satu product. contoh :
                                                <b>(BALL.TIM.KG)</b> 1 BALL isinya 10Kg, 1 TIM isinya 5Kg dan 1 KG isinya 1Kg.
                                            </li>
                                            <li>
                                                <b>Kategori,</b> digunakan untuk mengelompokkan product sesuai dengan jenisnya,
                                                contoh: Kategori Makanan, Kategori Minuman dan lainnya.
                                            </li>
                                            <li>
                                                <b>Satuan Beli,</b> satuan product yang akan digunakan saat terjadi pembelian
                                                product dari supplier.
                                            </li>
                                            <li>
                                                <b>Satuan Jual,</b> satuan product yang akan digunakan saat terjadi penjualan
                                                product ke customer, jika product memiliki satuan konversi maka product dapat
                                                memiliki lebih dari satu satuan penjualan (<b>seperti point 2</b>).
                                            </li>
                                            <li>
                                                <b>Harga Modal,</b> sebagai acuan harga pokok/modal penjualan product untuk
                                                masing-masing satuan jual yang dipilih.
                                            </li>

                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-sm btn-primary" id="btn_simpan">Simpan</button>
                    <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal" id="btn_batal">Batal</button>
                    <button type="button" class="btn btn-sm btn-info" data-dismiss="modal">Tutup</button>
                </div> --}}

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
    <!-- page script -->
    <script src="{{ asset('custom/js/myjs.js')}}"></script>
    <script src="{{ asset('custom/js/master-data/product.js')}}"></script>
@endsection


