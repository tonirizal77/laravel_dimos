@extends('ui_admin.layouts.main')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title')
    Data Customer / Pelanggan
@endsection

@section('title-page')
    <i class="fas fa-house-user"></i>
    Data Customer / Pelanggan
@endsection

@section('css-x')
    <!-- This Page -->
    <link rel="stylesheet" href="{{ asset('custom/css/style.css')}}">
@endsection

@section('content')
    <div class="content pt-2">
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
                    <button type="button" name="btn_tambah" id="btn_tambah" class="btn btn-sm btn-outline-primary"><i class="fas fa-plus-square"></i> Tambah Data</button>
                    <button type="button" name="btn_edit" id="btn_edit" class="btn btn-sm btn-outline-warning"><i class="fas fa-edit"></i> Edit Data</button>
                    <button type="button" name="btn_hapus" id="btn_hapus" class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i> Hapus Data</button>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize" data-toggle="tooltip" title="Fullscreen"><i class="fas fa-expand"></i></button>
                </div>
            </div>

            <div class="card-body p-0 table-responsive" style="height: 690px">
                <table id="tabel_customer" class="table table-sm table-bordered table-head-fixed table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 3%">No</th>
                            <th class="text-center" style="width: 10%">Username</th>
                            <th class="text-center" style="width: 10%">N a m a</th>
                            <th class="text-center" style="width: 10%">Tipe</th>
                            <th class="text-center" style="width: 10%">E-mail</th>
                            <th class="text-center">Alamat Lengkap</th>
                            <th class="text-center" style="width: 10%">Kota</th>
                            <th class="text-center" style="width: 10%">Telpon</th>
                            <th class="text-center" style="width: 5%">Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
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
                    <div class="align-self-center">
                        <i class="fas fa-circle nav-icon text-success"></i> Active
                        <i class="nav-icon fas fa-circle text-danger ml-2"></i> Non-Active
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
    <!-- /.content -->
    <!-- Modal Form Isian Data -->
    <div class="modal fade" id="modal_form_cs" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="modal_form_csTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-green" style="margin-bottom: 5px">
                    <h5 class="modal-title" id="modal_form_csTitle">Form Isian Data Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <form id="form_customer">
                    @csrf
                    <div class="modal-body" style="font-size: 14px !important">
                        <div class="form-errors row"></div>
                        <div class="row">
                            {{--/col 1--}}
                            <div class="col-sm-6 col-12">
                                <div class="card card-success shadow">
                                    <div class="card-header">
                                        <h3 class="card-title">Data Customer (Profile)</h3>
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="row">

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="nama_customer">Nama Customer</label>
                                                    <input type="text" class="form-control form-control-sm" name="nama_customer" id="nama_customer" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="telpon">No. Handphone</label>
                                                    <input type="text" name="telpon" id="telpon" class="form-control form-control-sm" placeholder="0XXX-XXXX-XXXX" maxlength="15">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <!-- textarea -->
                                                <div class="form-group">
                                                    <label>Alamat Lengkap</label>
                                                    <textarea name="alamat" id="alamat" class="form-control form-control-sm" rows="2" placeholder="Alamat..."></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="provinsi">Provinsi</label>
                                                    <select name="provinsi" id="provinsi" class="select2 form-control form-control-sm" style="width: 100%">
                                                        @forelse ( $provinsi as $prov )
                                                            <option value={{ $prov->id }}>{{ $prov->name }}</option>
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
                            </div>
                            {{--/col 2--}}
                            <div class="col-sm-6 col-12">
                                <div class="card card-success shadow">
                                    <div class="card-header">
                                        <h3 class="card-title">Data Pengguna (User Access)</h3>
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="row">
                                            {{-- <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="username">Username / Kode</label>
                                                    <input type="text" name="username" class="form-control form-control-sm" id="username" autocomplete="off">
                                                </div>
                                            </div> --}}
                                            <div class="col-sm-7">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="email">E-mail</label>
                                                    <input type="email" name="email" class="form-control form-control-sm" id="email">
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="password">Password</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password" class="form-control form-control-sm" value="123456" placeholder="" autocomplete="off" id="password">
                                                        <div class="input-group-append toggle-password">
                                                            <span id="toggle-password" class="input-group-text" style="padding: 2px 4px"><i class="fas fa-eye"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="status" class="col-form-label">Status :</label>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="active" name="status" value="1" checked>
                                                            <label for="active">Active</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="non-active" name="status" value="0">
                                                            <label for="non-active">Non-Active</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-green" id="note">
                                    Data Pengguna (User Access) digunakan untuk
                                    melakukan transaksi online dengan toko anda.
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="modal-footer justify-content-between">
                    <div class="container-fluid row">
                        <div class="col-lg-12 text-center">
                            <button type="button" class="btn btn-sm btn-primary" id="btn_simpan">Simpan</button>
                            <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal" id="btn_batal">Batal</button>
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
    <!-- This page -->
    <script src="{{ asset('custom/js/myjs.js')}}"></script>
    <script src="{{ asset('custom/js/master-data/customer.js')}}"></script>
    <script>
        $(function(){
            let spass = $(".toggle-password");
            spass.css("cursor: pointer");
            $("body").on('click', '.toggle-password', function() {
                let ipass = $("input[name=password]")
                if (ipass.attr("type") === "password") {
                    ipass.attr("type", "text");
                    $("span#toggle-password").html(`<i class="fas fa-eye-slash"></i>`)
                } else {
                    ipass.attr("type", "password");
                    $("span#toggle-password").html(`<i class="fas fa-eye"></i>`)
                }
            });
        })
    </script>
@endsection
