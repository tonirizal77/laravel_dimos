@extends('ui_admin.layouts.main')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title','Master Data - Kategori Product')

@section('title-page')
    <i class="fas fa-house-user"></i>
    Kategori Product / Barang
@endsection

@section('css-x')
    <style>
        .img_product {width: 100%;}
        .img-icons {
            width: 100px; height: auto;
        }
        .kategori-box > .info-box:hover {
            background-color:rgba(219, 222, 223, 0.425);
            /* cursor: pointer; */
        }
        span.nama:hover, span.no-card {
            cursor: pointer;
        }
        .selected-card {
            background-color:bisque !important;
        }
    </style>
@endsection

@section('content')
    <!-- Main content -->
    <div class="content pt-2">
        <div class="row">
            {{-- Daftar --}}
            <div class="col-lg-12">
                <div class="card card-info card-outline shadow-sm">
                    <div class="card-header">
                        <div class="card-title text-bold text-info"><i class="fas fa-address-card"></i> Daftar Category Barang</div>
                        <div class="card-tools">
                            <span id="btn_action"></span>
                            <button type="button" class="btn btn-sm btn-outline-success" id="btn_add"><i class="fas fa-plus-square"></i> Tambah Kategori</button>
                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-2" style="height: 750px;">
                        {{-- Grid --}}
                        <div class="row col-lg-3 col-md-3 col-sm-6 col-12"></div>
                        <div class="row" id="data-card"></div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.row -->
    </div>
    <!-- /.content -->
    <!-- Modal Form Isian Data -->
    <div class="modal fade" id="modal_form_kategori" tabindex="-1"
        data-bs-backdrop="static" data-bs-keyboard="false"
        aria-labelledby="modal_form_kategoriTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-info" style="margin-bottom: 5px">
                    <h5 class="modal-title" id="modal_form_kategoriTitle">Form Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <form id="form_category2">
                    @csrf
                    <div class="modal-body">
                        <div class="info-box p-2">
                            <span class="info-box-icon bg-info mr-2"><i class="far fa-question-circle"></i></span>
                            <div class="info-box-content">
                                <div class="row d-flex justify-content-between">
                                    <div class="form-group" style="width: 100%">
                                        <input class="form-control form-control-sm"  type="text" id="name" name="name" placeholder="Nama Kategori">
                                    </div>
                                </div>
                                <div class="row justify-content-between">
                                    <div class="form-group">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" id="status" name="status" checked>
                                            <label class="custom-control-label text-secondary text-sm" for="status">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <div class="container-fluid row">
                            <div class="col-lg-12 text-center btn_action_form">
                                <button type="button" class="btn btn-sm btn-primary" id="btn_simpan">Simpan</button>
                                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" id="btn_batal">Batal</button>
                                <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

@section('js-x')

    <!-- bs-custom-file-input -->
    {{-- <script src="{{ asset('ui_admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script> --}}
    {{-- jquery form --}}
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.form.js') }}"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('ui_admin/plugins/jquery/jquery.validate.js') }}"></script>
    <!-- page this -->
    <script src="{{ asset('custom/js/master-data/category.js')}}"></script>
@endsection

