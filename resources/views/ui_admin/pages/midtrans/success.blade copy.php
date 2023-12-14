@extends('ui_admin.layouts.main')

@section('title','Informasi Proses Payment')
@section('title-page','Informasi Proses Payment')

@php
    function rupiah($angka){
        // $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        $hasil_rupiah = number_format($angka,0,',',',');
        return $hasil_rupiah;
    };

    $hariIni = \Carbon\Carbon::now();

    function addDayDate($date, $day) //add days
    {
        $sum = strtotime(date("d-m-Y H:i:s", strtotime("$date")) . " +$day days");
        $dateTo = date('d-m-Y H:i:s', $sum);
        return $dateTo;
    }

    if ($data != null) {
        $history = $data['history'];
        $order = $data['order'];
        $items = $data['items'];
        $customer = $data['customer'];

        $tgl_transaksi = date('d-m-Y H:i:s', strtotime($history->transaction_time));
        $tgl_limit = addDayDate($tgl_transaksi, 1);
    }
@endphp

@section('content')
    <div class="content pt-2">
        <div class="row">
            @if ($data != null)
                <div class="col-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Pembayaran</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info"><i class="fab fa-first-order"></i></span>

                                        <div class="info-box-content">
                                        <span class="info-box-text">Order ID</span>
                                        <span class="info-box-number">{{$history->order_id}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success"><i class="fas fa-money-bill"></i></span>

                                        <div class="info-box-content">
                                        <span class="info-box-text">Amount</span>
                                        <span class="info-box-number">Rp. {{ rupiah($history->gross_amount)}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

                                        <div class="info-box-content">
                                        <span class="info-box-text">Payment Method</span>
                                        <span class="info-box-number">{{ strtoupper($history->payment_type) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

                                        <div class="info-box-content">
                                        <span class="info-box-text">Status Transaction</span>
                                        <span class="info-box-number"><span class="badge  badge-pill badge-info"> {{ strtoupper($history->transaction_status) }} </span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-info shadow">
                                <div class="card-header">
                                    <h3 class="card-title">Detail Order</h3>
                                    <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-5">Order ID</div><div class="col-sm-7 text-bold">{{ $history->order_id }}</div>
                                        <div class="col-sm-5">Tipe Pembayaran</div><div class="col-sm-7 text-bold">{{ strtoupper($history->payment_type) }}</div>
                                        <div class="col-sm-5">Jumlah</div><div class="col-sm-7 text-bold">Rp. {{ rupiah($history->gross_amount)}}</div>
                                        <div class="col-sm-5">Transaction ID</div><div class="col-sm-7 text-bold">{{$history->transaction_id}}</div>
                                        <div class="col-sm-5">Waktu</div><div class="col-sm-7 text-bold">{{ $tgl_transaksi }}</div>
                                        <div class="col-sm-5">Status</div><div class="col-sm-7 text-bold"><span class="badge badge-info badge-pill">{{ strtoupper($history->transaction_status) }}</span> </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card card-info shadow">
                                <div class="card-header">
                                    <h3 class="card-title">Detail Pelanggan</h3>
                                    <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-5">Nama</div><div class="col-sm-7">{{$customer->nama}}</div>
                                        <div class="col-sm-5">Telepon</div><div class="col-sm-7">+{{$customer->telpon}}</div>
                                        <div class="col-sm-5">Email</div><div class="col-sm-7">{{$customer->email}}</div>
                                        <div class="col-sm-5">Alamat</div><div class="col-sm-7">{{$customer->alamat}}, Kota {{$customer->kota->name}},
                                            <br>{{$customer->province->name}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card card-info shadow">
                                <div class="card-header">
                                    <h3 class="card-title">Detail Pembayaran</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if ( Str::contains($history->payment_type, 'bank_transfer') )
                                            @if ( property_exists($history, 'permata_va_number') )
                                                <div class="col-sm-5">Virtual Account</div><div class="col-sm-7 text-bold">{{ $history->permata_va_number}}</div>
                                                <div class="col-sm-5">Acquiring Bank</div><div class="col-sm-7 text-bold">Permata</div>
                                                <div class="col-sm-5">Waktu Kadaluarsa</div><div class="col-sm-7 text-bold">{{ $tgl_limit }}</div>
                                            @else
                                                <div class="col-sm-5">Virtual Account</div><div class="col-sm-7 text-bold">{{ $history->va_numbers[0]->va_number }}</div>
                                                <div class="col-sm-5">Acquiring Bank</div><div class="col-sm-7 text-bold">{{ strtoupper($history->va_numbers[0]->bank) }}</div>
                                                <div class="col-sm-5">Waktu Kadaluarsa</div><div class="col-sm-7 text-bold">{{ $tgl_limit }}</div>
                                            @endif
                                        @else
                                            {{-- // --}}
                                        @endif
                                        <div class="col-sm-5">Instruksi PDF</div><div class="col-sm-7 text-bold">
                                            <a href="{{ $history->pdf_url}}">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card card-info shadow">
                                <div class="card-header">
                                    <h3 class="card-title">Shipping Information</h3>
                                    <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-5">Nama</div><div class="col-sm-7">Toko Taruko</div>
                                        <div class="col-sm-5">Telepon</div><div class="col-sm-7">+6281212554585</div>
                                        <div class="col-sm-5">Alamat</div><div class="col-sm-7">Alamat Toko Taruko <br>Batam, <br>29413 Indonesia</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Detail Item --}}
                    <div class="col-12">
                        <div class="card card-info card-outline shadow">
                            <div class="card-header">
                                <h3 class="card-title">Detail Item</h3>
                                <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <table class="table table-bordered">
                                    <thead class="dark">
                                        <th>No</th>
                                        <th>Nama Paket</th>
                                        <th>Periode</th>
                                        <th>Biaya</th>
                                        <th>Jumlah</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Paket - {{ $items->name}}</td>
                                            <td>{{ $order->durasi }} - Bulan</td>
                                            <td>Rp. {{ rupiah($items->biaya)}}</td>
                                            <td>Rp. {{ rupiah($items->biaya*$order->durasi)}}</td>
                                        </tr>

                                    </tbody>
                                    <tfoot>
                                        <thead>
                                            <th colspan="4">Total</th>
                                            <th>Rp. {{ rupiah($items->biaya*$order->durasi)}}</th>
                                        </thead>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-3 justify-center">
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Informasi Pembayaran</h3>
                        </div>
                        <div class="card-body">
                            <div class="text-center">oops!!!, Data Order tidak ditemukan..!</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
