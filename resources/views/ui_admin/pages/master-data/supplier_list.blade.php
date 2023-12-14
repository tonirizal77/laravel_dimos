@extends('ui_admin.layouts.main')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title')
    Data Supplier / Vendor
@endsection

@section('title-page')
    <i class="fas fa-house-user"></i>
    Data Supplier / Vendor
@endsection

@section('css-x')
    <!-- This Page -->
    <link rel="stylesheet" href="{{ asset('custom/css/style.css')}}">
@endsection

@section('content')
    <!-- Main content -->
    <div class="content pt-2 pb-2">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-info card-outline mb-0">
                    <div class="card-header">
                        <div class="card-title text-lg text-bold text-info">
                            {{-- <i class="fas fa-house-user"></i> Daftar Pelanggan / Customer --}}
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
                                        <label for="filter_data" class="text-right mb-0 text-secondary pr-2 align-self-center">Filter Data :</label>
                                        <input type="search" name="filter_data" id="filter_data" class="form-control form-control-sm">
                                        <div class="input-group-append" id="btn_group">
                                            <button type="button" id="filter_action" class="btn btn-info"
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
                            {{-- <button type="button" name="btn_tambah" id="btn_tambah" class="btn btn-sm btn-outline-primary"><i class="fas fa-plus-square"></i> Tambah Data</button>
                            <button type="button" name="btn_edit" id="btn_edit" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i> Edit Data</button>
                            <button type="button" name="btn_hapus" id="btn_hapus" class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i> Hapus Data</button> --}}
                            <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Fullscreen"><i class="fas fa-expand"></i></button>
                        </div>
                    </div>

                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="card card-outline card-info shadow">
                                    <div class="card-header">
                                        <h3 class="card-title text-bold">Form Supplier</h3>
                                    </div>
                                    <form id="form_supplier">
                                        <div id="method"></div>
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="nama">Nama</label>
                                                        <input type="text" class="form-control form-control-sm" name="nama" style='text-transform:uppercase'/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <!-- textarea -->
                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        <textarea class="form-control form-control-sm" rows="3" name="alamat"></textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="kota">Provinsi</label>
                                                        <select name="provinsi" id="provinsi" class="select2 form-control form-control-sm" style="width: 100%">
                                                            @forelse ( $provinsi as $prov )
                                                                @if ($prov->id == Auth::user()->cities_id)
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

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <!-- select -->
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="telpon">Telpon</label>
                                                        <input type="text" class="form-control form-control-sm" name="telpon">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="status">Status</label>
                                                        <div class="form-group clearfix">
                                                            <div class="icheck-primary d-inline">
                                                                <input type="radio" class="form-control" id="status_active" name="status" value="1" checked>
                                                                <label for="status_active" style="font-weight: normal">Active</label>
                                                            </div>
                                                            <div class="icheck-primary d-inline">
                                                                <input type="radio" class="form-control" id="status_non" name="status" value="0" >
                                                                <label for="status_non" style="font-weight: normal">Non-Active</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                            </div>
                                        </div>

                                        <div class="card-footer text-center">
                                            <button class="btn btn-sm btn-primary" type="button" id="btn_add">Tambah Data</button>
                                            <span id="btn_action"></span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-9 table-responsive" style="height: 670px;">
                                <table id="tabel_supplier" class="table table-sm table-bordered table-head-fixed table-hover " >
                                    <thead>
                                        <tr>
                                            <th class="text-center">ID</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Alamat</th>
                                            <th class="text-center">Kota</th>
                                            <th class="text-center">Telpon</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
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
    </div>
    <!-- /.content -->
@endsection

@section('js-x')

    <!-- InputMask -->
    <script src="{{ asset('ui_admin/plugins/inputmask/jquery.inputmask.min.js')}}"></script>
    {{-- jquery Foam --}}
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.form.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.validate.js') }}"></script>
    <!-- This page script -->
    <script src="{{ asset('custom/js/master-data/supplier.js')}}"></script>
@endsection
