@extends('ui_admin.layouts.main')

@section('title','Dashboard')

@section('css-x')
    <!-- This Page -->
    <link rel="stylesheet" href="{{ asset('custom/css/style.css')}}">
@endsection

@section('content')
    <div class="content pt-2">
        {{-- Status Toko --}}
        <div class="row">
            @if ($usaha != null)
                @if ($usaha->status == false)
                    <div class="col-lg-4">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="m-0"><i class="fas fa-store text-primary"></i> Status Toko Anda</h5>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <ul class="card-text">
                                    <li>Selamat <b>{{ Auth::user()->name }}</b>, anda telah memiliki Toko Online
                                        yang bernama <span class="text-blue"> {{ $usaha->nama }} </span>
                                        untuk melakukan transaksi jual beli secara online.</li>
                                    <li>Saat ini Toko anda belum aktif, untuk mulai berjualan silahkan diaktifkan.</li>
                                </ul>
                                <a href="{{route('account.index')}}" class="card-link d-flex align-self-end">Aktifkan Toko Saya</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-4">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <h5 class="card-title m-0"><i class="fas fa-user-check text-info"></i>  Status {{$usaha->nama}} - OK</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="text-bold">Selamat {{$usaha->nama}}, Akun Usaha anda sudah aktif</h6>

                                @if ($usaha->status_db == 0)
                                    <p class="card-text">Tinggal 1 (satu) langkah lagi untuk memulai aktifitas Toko Anda.</p>
                                    <p class="card-text">Silahkan lanjutkan persiapan Database Toko Anda</p>
                                    <button class="btn btn-sm btn-primary" id="btn_create_data"><i class="fas fa-database"></i> Lanjutkan Persiapan Database</button>
                                    {{-- <a href="{{ route('create-dataclient') }}" class="btn btn-sm btn-primary"><i class="fas fa-database"></i> Lanjutkan Persiapan Database</a> --}}
                                @else
                                    <p class="card-text">Silahkan lanjutkan persiapan database toko anda</p>
                                    <p class="card-text">Awali dengan memasukkan master data.</p>
                                @endif

                            </div>
                            <div id="progress_animation" class="overlay dark align-content-center" style="display: none">
                                <div class="col-10">
                                    <div class="info-box" id="progress-box">
                                        <span class="info-box-icon">
                                            <i class="loading"></i>
                                            <span id="percent_bar" class="absolute" style="font-size: 17px">0%</span>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-number" id="title_progress">Mohon Menunggu</span>
                                            <span class="info-box-text" id="status_progress">Sedang Proses Persiapan Toko...</span>
                                        </div>
                                    </div>
                                </div>
                            </div><!--progress-bar-->
                        </div>
                    </div>
                @endif
            @else
                <div class="col-lg-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <h5 class="card-title"><b>Selamat <b>{{ Auth::user()->name }}</b></b></h5>
                            <ul class="card-text">
                                <li>Saat ini anda memiliki kesempatan untuk membuka toko online dan
                                    melakukan transaksi jual beli secara online.</li>
                                <li>Toko anda belum tersedia, silahkan lengkapi data Toko anda dan
                                    segera diaktifkan.</li>
                            </ul>
                            <a href="{{route('profile-usaha.index')}}" class="card-link">Buat Toko Saya</a>
                            {{-- <a href="#" class="card-link">Pengaturan Data Toko</a> --}}
                        </div>
                    </div><!-- /.card -->
                </div>
            @endif
        </div>
        <!-- /.row -->
    </div>
<!-- /.content -->
@endsection

@section('js-x')
    <script src="{{ asset('custom/js/lain-lain/dashboard.js') }}"></script>
@endsection
