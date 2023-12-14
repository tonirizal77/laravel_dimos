@extends('ui_admin.layouts.main')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title','Admin - Customer')
@section('css-x')
    <!-- This Page -->
    <link rel="stylesheet" href="{{ asset('custom/css/style.css')}}">
    <style>
        .form-control {font-size: 16px !important}
        .radio-custom1 > input[type=radio] {
            display: none;
        }
        .radio-custom1 > input[type=radio]:not(:disabled) ~ label {
            cursor: pointer;
        }
        .radio-custom1 > input[type=radio]:disabled ~ label {
            border-color: #bcc2bf;
            box-shadow: none;
            cursor: not-allowed;
        }
        .radio-custom1 label {
            /* height: 100%;
            background: white;
            border: 2px solid #20df80;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            text-align: center;
            box-shadow: 0px 3px 10px -2px rgba(161, 170, 166, 0.5);
            position: relative; */
            display: block;
            font-weight: 500 !important;
        }
        .radio-custom1 label:hover > .info-box {
            background-color: beige;
        }
        .radio-custom1 > input[type=radio]:checked + label {
            box-shadow: 0px 0px 20px rgba(0, 255, 128, 0.75);
        }
        .radio-custom1 > input[type=radio]:checked + label::after {
            color: #3d3f43;
            font-family: "Font Awesome 5 Free";
            border: 2px solid #1dc973;
            content: "";
            font-size: 18px;
            position: absolute;
            top: 5px;
            left: 27px;
            transform: translateX(-50%);
            height: 28px;
            width: 28px;
            line-height: 28px;
            text-align: center;
            border-radius: 50%;
            background: beige;
            box-shadow: 0px 2px 5px -2px rgba(0, 0, 0, 0.25);
            font-weight: 600;
        }
        /* .radio-custom1 > input[type=radio]#tipe_distributor:checked + label {
            background: red;
            border-color: red;
        } */
    </style>
@endsection

@section('content')
    <div class="content pt-2 pb-2">
        <div class="container-fluid">
            <div class="card card-success card-outline">
                <div class="card-header">
                    @php
                        $tipe_info = "";
                        if (Auth::user()->tipe == "1") {
                            $tipe_info = "(User Distributor)";
                        } else if (Auth::user()->tipe == "2") {
                            $tipe_info = "(User Store)";
                        }
                    @endphp
                    <h3 class="card-title text-bold">Daftar Customer {{$tipe_info}}</h3>
                    <div class="card-tools">
                        <button type="button" name="btn_tambah" id="btn_tambah" class="btn btn-sm btn-primary">Tambah Customer</button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i></button>
                    </div>
                </div>
                <div class="card-body" style="padding:10px;">
                    <div class="row">
                        {{-- Tabel Customer --}}
                        <div class="col-lg-12">
                            <div class="card card-success shadow-sm">
                                <div class="card-header">
                                    <h3 class="card-title">Daftar Customer</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body p-0" style="height: 690px">
                                    {{-- table-head-fixed --}}
                                    <div class="table-responsive" style="height: 650px;">
                                        <table id="tabel_customer" class="table table-sm table-bordered table-striped table-head-fixed table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" style="width: 3%">ID</th>
                                                    <th class="text-center" style="width: 10%">N a m a</th>
                                                    <th class="text-center" style="width: 8%">Username</th>
                                                    <th class="text-center" style="width: 8%">Tipe Access</th>
                                                    <th class="text-center" style="width: 10%">E-mail</th>
                                                    <th class="text-center">Alamat Lengkap</th>
                                                    <th class="text-center" style="width: 10%">Telpon</th>
                                                    <th class="text-center" style="width: 5%">Status</th>
                                                    <th class="text-center">Usaha</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i=1;$i <= 100;$i++)
                                                    <tr>
                                                        <td class="text-center">{{$i}}</td>
                                                        <td>Toko ABC</td>
                                                        <td class="text-center">Username-unik</td>
                                                        <td class="text-center">Store - Admin</td>
                                                        <td class="text-center">email@gmail.com</td>
                                                        <td>Jl. Jend. Sudirman No. 45 RT.012 RW.012</td>
                                                        <td>0822-1254-2505</td>
                                                        <td class="text-center">Active</td>
                                                        <td class="text-center">Toko Butik - Jakarta</td>
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
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
                            <h5 class="col-sm-12 text-center text-bold">Pilih Tipe Customer</h5>

                            <div class="col-sm-4 radio-custom1">
                                <input type="radio" name="tipe_cs" value="1" id="tipe_distributor">
                                <label for="tipe_distributor">
                                    <div class="info-box m-0">
                                        <span class="info-box-icon bg-success">
                                            <i class="fas fa-store"></i>
                                        </span>
                                        <div class="info-box-content" style="line-height: 1.25em">
                                            <span class="info-box-number">Distributor</span>
                                            <span class="info-box-text text-sm text-wrap">Bisa Transaksi Jual Beli Bagi pelanggannya.</span>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="col-sm-4 radio-custom1">
                                <input type="radio" name="tipe_cs" value="2" id="tipe_store" checked>
                                <label for="tipe_store">
                                    <div class="info-box m-0">
                                        <span class="info-box-icon bg-success">
                                            <i class="fas fa-store"></i>
                                        </span>
                                        <div class="info-box-content" style="line-height: 1.25em">
                                            <span class="info-box-number">Store (Toko, Agen, dll)</span>
                                            <span class="info-box-text text-sm text-wrap">Bisa Transaksi Jual Beli Bagi pelanggannya.</span>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            <div class="col-sm-4 radio-custom1">
                                <input type="radio" name="tipe_cs" value="3" id="tipe_customer">
                                <label for="tipe_customer">
                                    <div class="info-box m-0">
                                        <span class="info-box-icon bg-success">
                                            <i class="fas fa-users"></i>
                                        </span>
                                        <div class="info-box-content" style="line-height: 1.25em">
                                            <span class="info-box-number">Customer (consumen)</span>
                                            <span class="info-box-text text-sm text-wrap">Hanya bisa Transaksi Pembelian.</span>
                                        </div>
                                    </div>
                                </label>
                            </div>

                        </div>

                        <div class="row">
                            {{--/col 1--}}
                            <div class="col-sm-6 col-12">
                                <div class="card card-success shadow">
                                    <div class="card-header">
                                        <h3 class="card-title">Data Customer (Profile)</h3>
                                        {{-- <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div> --}}
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="row">
                                            {{-- tipe select --}}
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-7">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="nama_usaha">Nama Store (Usaha/Toko)</label>
                                                    <input type="text" class="form-control form-control-sm" name="nama_usaha" id="nama_usaha" placeholder="">
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="nama_customer">Nama Customer</label>
                                                    <input type="text" class="form-control form-control-sm" name="nama_customer" id="nama_customer" placeholder="">
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
                                                    <label class="col-form-label" for="kota">Kota</label>
                                                    <input type="text" name="kota" id="kota"  class="form-control form-control-sm">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label class="col-form-label" for="telpon">Telpon</label>
                                                    <input type="text" name="telpon" id="telpon" class="form-control form-control-sm">
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
                                        {{-- <div class="card-tools">
                                            <button tabindex="-1" type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </div> --}}
                                    </div>
                                    <div class="card-body p-2">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <!-- select -->
                                                <div class="form-group">
                                                    <label class="col-form-label" for="username">Username</label>
                                                    <input type="text" name="username" class="form-control form-control-sm" id="username" autocomplete="off">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="email">E-mail</label>
                                                    <input type="email" name="email" class="form-control form-control-sm" id="email">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                {{-- <div class="form-group">
                                                    <label class="col-form-label" for="password">Password</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password" class="form-control form-control-sm" placeholder="" autocomplete="off" id="password">
                                                        <div class="input-group-append toggle-password">
                                                            <span id="toggle-password" class="input-group-text" style="padding: 2px 4px"><i class="fas fa-eye"></i></span>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                                <div class="form-group">
                                                    <label for="status" class="col-form-label">Status :</label>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="active" name="status" value="1" checked>
                                                            <label for="active">Active</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="non-active" value="0" name="status">
                                                            <label for="non-active">Non-Active</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="col-form-label" for="tipe-user">Tipe Access</label>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="admin" name="tipe_user" value="1" checked>
                                                            <label for="admin">Admin</label>
                                                        </div>
                                                        <div class="icheck-primary d-inline">
                                                            <input type="radio" id="user" value="2" name="tipe_user">
                                                            <label for="user">User</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="form-group row">
                                            <label for="status" class="col-md-3 col-form-label">Status :</label>
                                            <div class="col-md-9 align-self-center">
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" id="active" name="status" value="1" checked>
                                                    <label for="active">Active</label>
                                                </div>
                                                <div class="icheck-primary d-inline">
                                                    <input type="radio" id="non-active" value="0" name="status">
                                                    <label for="non-active">Non-Active</label>
                                                </div>
                                            </div>
                                            Password : 123456
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--/row--}}
                    </div>
                </form>

                <div class="modal-footer justify-content-between">
                    <div class="container-fluid row">
                        <div class="col-lg-12 text-center">
                            <button type="button" class="btn btn-sm btn-primary" id="btn_simpan">Simpan</button>
                            <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal" id="btn_batal">Batal</button>
                            <button type="button" class="btn btn-sm btn-info" data-dismiss="modal">Tutup</button>
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
