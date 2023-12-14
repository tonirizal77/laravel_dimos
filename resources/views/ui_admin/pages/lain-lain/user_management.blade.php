@extends('ui_admin.layouts.main')

@section('token')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('title')
    User Management
@endsection

@section('title-page')
    <i class="fas fa-house-user"></i>
    User Management
@endsection

@section('css-x')
    <!-- This Page -->
    <link rel="stylesheet" href="{{ asset('custom/css/style.css')}}">
    <style>
        :focus-visible {
            outline: auto 1px #17a2b8 !important;
        }
        #main-card > .card-header .nav-link.active {
            background-color: #17a2b8 !important;
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
        case '0':
            $roles = 'Owner';
            break;
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
            $roles = 'Lainnya';
            break;
    }
@endphp

@section('content')
    <div class="content pt-2 pb-2">
        <div class="row">
            <div class="col-12">
                <div class="card card-outline mb-0" id="main-card">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title text-info p-3"><i class="fas fa-house-user"></i> User Management</h3>
                        <ul class="nav nav-pills nav-compact ml-auto p-2">
                            <li class="nav-item"><a class="nav-link active" href="#daftar-user" data-toggle="tab"><i class="fas fa-user"></i> Daftar User</a></li>
                            <li class="nav-item"><a class="nav-link" href="#menu-akses" data-toggle="tab"><i class="fas fa-address-card"></i> Menu Akses</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="daftar-user">
                                <div class="row justify-content-between">
                                    <!-- Tabel Info -->
                                    <div class="col-lg-4 col-sm-12">
                                        <form id="form_user_profile" enctype="multipart/form-data" autocomplete="off">
                                            <div id="method"></div>
                                            @csrf
                                            <div class="card card-info card-outline shadow-lg">
                                                <div class="card-header">
                                                    <h3 class="card-title text-info"><i class="fas fa-user text-info"></i> Data User (Profile) </h3>
                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-outline-success btn-xs" id="btn_add_profile">
                                                            <i class="fas fa-plus-square"></i> Tambah User
                                                        </button>
                                                        <button type="button" class="btn btn-outline-info btn-xs" id="btn_edit_profile">
                                                            <i class="fas fa-edit"></i> Edit User
                                                        </button>
                                                        <span id="btn_action_1"></span>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row form-errors justify-content-center"></div>
                                                    <!-- Profile Image -->
                                                    <div class="row">
                                                        <div class="col-sm-6 align-self-center">
                                                            <div class="custom-upload-file text-center">
                                                                <input type="file" name="gambar" id="inputFile" disabled/>
                                                                <label for="inputFile" class="mb-0">
                                                                    <div class="box-img-circle">
                                                                        <img id="previewImg"
                                                                            src="{{asset('ui_admin/dist/img/user7-128x128.jpg')}}"
                                                                            alt="User profile picture">
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label" for="nama_user">Nama Pengguna</label>
                                                                <input type="text" class="form-control form-control-border" autocomplete="off" name="nama_user" id="nama_user">
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="d-flex justify-content-between">
                                                                    <label class="col-form-label" for="telpon">No.HP</label>
                                                                    <a href="#" class="nav-link text-danger text-sm pr-0" id="verifikasi_hp">Verifikasi <i class="fas fa-bell-slash"></i> </a>
                                                                </div>
                                                                <input type="text" name="telpon" id="telpon" class="form-control form-control-border" maxlength="15">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <!-- textarea -->
                                                            <div class="form-group">
                                                                <label>Alamat Lengkap</label>
                                                                <textarea name="alamat" id="alamat" class="form-control form-control-border" rows="2" placeholder="Alamat..."></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label" for="kota">Provinsi</label>
                                                                <select name="provinsi" id="provinsi" class="select2 form-control form-control-sm" style="width: 100%">
                                                                    @forelse ( $provinsi as $prov )
                                                                        @if ($prov->id == $user->prov_id)
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
                                                </div>
                                            </div>

                                            <div class="card card-info card-outline shadow-lg">
                                                <div class="card-header">
                                                    <div class="row justify-content-between">
                                                        <div class="col-6">
                                                            <h3 class="card-title text-info"><i class="fas fa-address-book"></i> Data Access</h3>
                                                        </div>
                                                        <div class="col-6 text-right">
                                                            <button type="button" class="btn btn-xs btn-outline-info" id="btn_edit_access"><i class="fas fa-edit"></i> Edit</button>
                                                            <span id="btn_action_2"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label" for="username">Username / Kode</label>
                                                                <input type="text" name="username" maxlength="20"  minlength="6" class="form-control form-control-border" id="username" autocomplete="off" disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <div class="d-flex justify-content-between">
                                                                    <label class="col-form-label" for="email">E-mail</label>
                                                                    <a href="#" class="nav-link text-danger text-sm pr-0" id="verifikasi_email">Verifikasi <i class="fas fa-bell-slash"></i> </a>
                                                                </div>
                                                                <input type="email" name="email" class="form-control form-control-border" id="email">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label class="col-form-label" for="password">Password</label>
                                                                <div class="input-group">
                                                                    <input type="password" name="password" class="form-control form-control-border" placeholder="" autocomplete="off" id="password">
                                                                    <div class="input-group-append toggle-password">
                                                                        <span id="toggle-password" class="input-group-text" style="padding: 2px 4px"><i class="fas fa-eye"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-sm-6">
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

                                                    <div class="row">
                                                        <label for="posisi" class="col-sm-2 col-form-label align-self-center">Posisi :</label>
                                                        <div class="col-sm-10 align-self-center">
                                                            <div class="form-group clearfix mb-0 justify-content-between">
                                                                <div class="icheck-primary d-inline" title="Hak Akses Semua">
                                                                    <input type="radio" id="admin" name="posisi" value="1">
                                                                    <label for="admin">Admin</label>
                                                                </div>
                                                                <div class="icheck-primary d-inline" title="Hak Akses seperti Admin">
                                                                    <input type="radio" id="user" name="posisi" value="2" checked>
                                                                    <label for="user">User</label>
                                                                </div>
                                                                <div class="icheck-primary d-inline" title="Hak Akses khusus Kasir">
                                                                    <input type="radio" id="kasir" name="posisi" value="3">
                                                                    <label for="kasir">Kasir</label>
                                                                </div>
                                                                <div class="icheck-primary d-inline" title="Hak Akses khusus Accounting">
                                                                    <input type="radio" id="accounting" name="posisi" value="4">
                                                                    <label for="accounting">Acc.</label>
                                                                </div>
                                                                <div class="icheck-primary d-inline" title="Hak Akses terbatas">
                                                                    <input type="radio" id="staff" name="posisi" value="5">
                                                                    <label for="staff">Staff</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Tabel User-->
                                    <div class="col-lg-8 col-sm-12">
                                        <h5 class="text-left"><i class="text-info fas fa-chalkboard-teacher"></i> Daftar Pengguna (User)</h5>
                                        <table class="table table-bordered table-hover table-head-fixed" id="tabel_rinci">
                                            <thead class="text-center align-self-center">
                                                <tr>
                                                    <th >No</th>
                                                    <th >Nama Pengguna</th>
                                                    <th >Hak Akses<br>Status</th>
                                                    <th >Alamat</th>
                                                    <th >Telpon & <br>Email</th>
                                                    <th >Setting<br>Akses</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="menu-akses">
                                <div class="row justify-content-around">
                                    <div class="col-md-3">
                                        <!-- Profile Image -->
                                        <div class="custom-upload-file text-center">
                                            <input type="file" name="inputFile" id="inputFile" onchange="previewFile(this)" disabled/>
                                            <label for="inputFile">
                                                <div class="box-img-circle">
                                                    @if ($user->profilePicture != null)
                                                        <img id="previewImg"
                                                            src="{{ url('/profile') .'/'. $user->profilePicture }}"
                                                            alt="User profile picture">
                                                    @else
                                                        <img id="previewImg"
                                                        src="{{asset('ui_admin/dist/img/user7-128x128.jpg')}}"
                                                        alt="User profile picture">
                                                    @endif
                                                </div>
                                            </label>
                                        </div>

                                        <h3 class="profile-username text-center">{{$user->name}}</h3>
                                        <p class="text-muted text-center">{{$user->email}}</p>

                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Username</b> <a class="float-right">{{$user->username}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Akses ke Usaha</b> <a class="float-right">{{$user->nama_usaha}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Alamat Lengkap</b> <a class="float-right">{{$user->alamat}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Kota</b> <a class="float-right kota" data-prov="{{$user->prov_id}}" data-kota="{{$user->cities_id}}">{{$user->kota}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>No. Telpon</b> <a class="float-right">{{$user->telpon}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Hak Akses</b> <a class="float-right">{{$roles}}</a>
                                            </li>

                                        </ul>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="pl-2 mb-2 text-info"><i class="fas fa-laptop"></i> Tentukan Hak Akses untuk masing-masing user pada kolom dibawah ini</div>
                                        <div class="card card-info card-outline card-outline-tabs shadow-lg">
                                            <div class="card-header p-0 border-bottom-0">
                                                <ul class="nav nav-tabs" id="ctabs-tab" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="ctabs-master-tab"
                                                            data-toggle="pill" href="#ctabs-master" role="tab"
                                                            aria-controls="ctabs-master" aria-selected="true">Master Data</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="ctabs-transaksi-tab"
                                                            data-toggle="pill" href="#ctabs-transaksi" role="tab"
                                                            aria-controls="ctabs-transaksi" aria-selected="false">Transaksi</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="ctabs-stockMgm-tab"
                                                            data-toggle="pill" href="#ctabs-stockMgm" role="tab"
                                                            aria-controls="ctabs-stockMgm" aria-selected="false">Management Stock</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="ctabs-laporan-tab"
                                                            data-toggle="pill" href="#ctabs-laporan" role="tab"
                                                            aria-controls="ctabs-laporan" aria-selected="false">Laporan</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="ctabs-setting-tab"
                                                            data-toggle="pill" href="#ctabs-setting" role="tab"
                                                            aria-controls="ctabs-setting" aria-selected="false">Pengaturan</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content" id="ctabs-tabContent">
                                                    <div class="tab-pane fade active show" id="ctabs-master" role="tabpanel" aria-labelledby="ctabs-master-tab">
                                                        <table class="table">
                                                            <thead class="text-center">
                                                                <th style="width: 50%">Uraian</th>
                                                                <th>Delete</th>
                                                                <th>Edit</th>
                                                                <th>Append</th>
                                                                <th>Print</th>
                                                                <th>Open</th>
                                                            </thead>
                                                            <tbody>
                                                                @php
                                                                    $menu = '[
                                                                        {"kdm":"m1", "nama":"Kategori Barang"},
                                                                        {"kdm":"m2", "nama":"Satuan Barang"},
                                                                        {"kdm":"m3", "nama":"Products/Barang"},
                                                                        {"kdm":"m4", "nama":"Supplier/Vendor"},
                                                                        {"kdm":"m5", "nama":"Pelanggan/Customer"},
                                                                    ]';
                                                                    $menus = json_decode($menu, true);
                                                                    var_dump($menus);
                                                                @endphp

                                                                @for ($i = 1; $i <= 5; $i++)
                                                                    <tr>
                                                                        <td>1. Data Kategori</td>
                                                                        <td class="text-center">
                                                                            <div class="icheck-info d-inline">
                                                                                <input type="checkbox" id="m11" checked>
                                                                                <label for="m11"></label>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="icheck-info d-inline">
                                                                                <input type="checkbox" id="m12" checked>
                                                                                <label for="m12"></label>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="icheck-info d-inline">
                                                                                <input type="checkbox" id="m13" checked>
                                                                                <label for="m13"></label>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="icheck-info d-inline">
                                                                                <input type="checkbox" id="m14" checked>
                                                                                <label for="m14"></label>
                                                                            </div>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <div class="icheck-info d-inline">
                                                                                <input type="checkbox" id="m15" checked>
                                                                                <label for="m15"></label>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endfor

                                                                <tr>
                                                                    <td>1. Data Kategori</td>
                                                                    <td class="text-center">
                                                                        <div class="icheck-info d-inline">
                                                                            <input type="checkbox" id="m11" checked>
                                                                            <label for="m11"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="icheck-info d-inline">
                                                                            <input type="checkbox" id="m12" checked>
                                                                            <label for="m12"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="icheck-info d-inline">
                                                                            <input type="checkbox" id="m13" checked>
                                                                            <label for="m13"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="icheck-info d-inline">
                                                                            <input type="checkbox" id="m14" checked>
                                                                            <label for="m14"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <div class="icheck-info d-inline">
                                                                            <input type="checkbox" id="m15" checked>
                                                                            <label for="m15"></label>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <div class="tab-pane fade" id="ctabs-transaksi" role="tabpanel" aria-labelledby="ctabs-transaksi-tab">
                                                        Transaksi
                                                    </div>

                                                    <div class="tab-pane fade" id="ctabs-stockMgm" role="tabpanel" aria-labelledby="ctabs-stockMgm-tab">
                                                        Stock Management
                                                    </div>

                                                    <div class="tab-pane fade" id="ctabs-laporan" role="tabpanel" aria-labelledby="ctabs-laporan-tab">
                                                        Laporan
                                                    </div>
                                                    <div class="tab-pane fade" id="ctabs-setting" role="tabpanel" aria-labelledby="ctabs-setting-tab">
                                                        Pengaturan
                                                    </div>
                                                </div>
                                                <i class="fas fa-anchor"></i><u><b>Keterangan:</b></u>
                                                <div class="col-12 mt-2">
                                                    <dl class="row">
                                                        <dt class="col-sm-1"><span class="badge btn-block badge-danger">Delete</span></dt>
                                                            <dd class="col-sm-11 text-danger mb-0">Memilik semua hak, termasuk menghapus (delete) data/file.</dd>
                                                        <dt class="col-sm-1 text-danger mb-0"><span class="badge btn-block badge-warning">Edit</span></dt>
                                                            <dd class="col-sm-11 text-warning mb-0">Bisa mengubah (Edit) data.</dd>
                                                        <dt class="col-sm-1 text-info"><span class="badge btn-block badge-info">Append</span></dt>
                                                            <dd class="col-sm-11 text-info mb-0">Bisa menambah (Append) data, tetapi tdk bisa menghapus data yang sudah ada.</dd>
                                                        <dt class="col-sm-1 text-success"><span class="badge btn-block badge-success">Print</span></dt>
                                                            <dd class="col-sm-11 text-success mb-0">Boleh mencetak (Print) data/laporan, tetapi tdk bisa menambah/mengubah data.</dd>
                                                        <dt class="col-sm-1 text-dark"><span class="badge btn-block badge-dark">Open</span></dt>
                                                            <dd class="col-sm-11 text-dark mb-0">Hanya bisa melihat atau menjalankan (Open) fasilitas program.</dd>
                                                    </dl>
                                                </div>
                                            </div>
                                            <!-- /.card -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--tab-content-->
                    </div><!--card-body-->
                </div><!--card-->
            </div><!--cols-2-->
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
    <script src="{{ asset('custom/js/lain-lain/user-management.js')}}"></script>
@endsection
