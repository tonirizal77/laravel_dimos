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

        if ($history->payment_type == 'echannel') {
            $payment_type = 'Mandiri Bill';
            # code...
        } else if ($history->payment_type == 'bank_transfer') {
            $payment_type = 'Bank Transfer';
            # code...
        }
        if ($history->transaction_status == 'settlement') {
            $transaction_status = 'Lunas';
        } else {
            $transaction_status = $history->transaction_status;
        }

    }
@endphp

@section('content')
    <div class="content pt-2">
        <div class="row">
            @if ($data != null)
                <div class="col-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-shield"></i> Informasi Pembayaran</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool">
                                    <i class="fas fa-backward"></i>
                                    {{-- <a href="javascript:history.go(-1)">Kembali</a> --}}
                                    <a href="{{ route('account.index') }}">Kembali ke Akun Usaha</a>
                                </button>
                            </div>
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
                                            <span class="info-box-number">{{ strtoupper($payment_type) }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

                                        <div class="info-box-content">
                                        <span class="info-box-text">Status Transaction</span>
                                        <span class="info-box-number"><span class="badge  badge-pill badge-info"> {{ strtoupper($transaction_status) }} </span></span>
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
                                        <div class="col-sm-5">Tipe</div><div class="col-sm-7 text-bold">{{ strtoupper($payment_type) }}</div>
                                        <div class="col-sm-5">Jumlah</div><div class="col-sm-7 text-bold">Rp. {{ rupiah($history->gross_amount)}}</div>
                                        <div class="col-sm-5">Transaction ID</div><div class="col-sm-7 text-bold">{{$history->transaction_id}}</div>
                                        <div class="col-sm-5">Waktu</div><div class="col-sm-7 text-bold">{{ $tgl_transaksi }}</div>
                                        <div class="col-sm-5">Status</div><div class="col-sm-7 text-bold"><span class="badge badge-info badge-pill">{{ strtoupper($transaction_status) }}</span> </div>
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
                                                <div class="col-sm-5">Nama Bank</div><div class="col-sm-7 text-bold">Permata</div>
                                            @else
                                                <div class="col-sm-5">Virtual Account</div><div class="col-sm-7 text-bold">{{ $history->va_numbers[0]->va_number }}</div>
                                                <div class="col-sm-5">Nama Bank</div><div class="col-sm-7 text-bold">{{ strtoupper($history->va_numbers[0]->bank) }}</div>
                                            @endif
                                            <div class="col-sm-5">Batas Bayar</div><div class="col-sm-7 text-bold">{{ $tgl_limit }}</div>
                                        @else
                                            @if ( Str::contains($history->payment_type, 'echannel') )
                                                <div class="col-sm-5">Kode Pembayaran</div><div class="col-sm-7 text-bold">{{ $history->bill_key}}</div>
                                                <div class="col-sm-5">Kode Perusahaan</div><div class="col-sm-7 text-bold">{{ $history->biller_code}}</div>
                                                <div class="col-sm-5">Nama Bank</div><div class="col-sm-7 text-bold">Mandiri</div>
                                            @endif
                                        @endif

                                        @if ( property_exists($history, 'pdf_url') )
                                            <div class="col-sm-5">Instruksi PDF</div><div class="col-sm-7 text-bold">
                                                <a href="{{ $history->pdf_url}}">Download</a>
                                            </div>
                                        @endif
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
                                        <div class="col-sm-3">Nama</div><div class="col-sm-9 text-bold">{{$customer->nama}}</div>
                                        <div class="col-sm-3">Telepon</div><div class="col-sm-9 text-bold">+{{$customer->telpon}}</div>
                                        <div class="col-sm-3">Email</div><div class="col-sm-9 text-bold">{{$customer->email}}</div>
                                        <div class="col-sm-3">Alamat</div>
                                        <div class="col-sm-9 text-bold">{{$customer->alamat}},
                                            Kota {{$customer->kota->name}},
                                            Provinsi {{$customer->province->name}}
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
                                        <div class="col-sm-3">Nama</div><div class="col-sm-9 text-bold">{{$customer->nama}}</div>
                                        <div class="col-sm-3">Telepon</div><div class="col-sm-9 text-bold">{{$customer->telpon}}</div>
                                        <div class="col-sm-3">Alamat</div>
                                        <div class="col-sm-9 text-bold">{{$customer->alamat}},
                                            Kota {{$customer->kota->name}},
                                            Provinsi {{$customer->province->name}}
                                        </div>
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
                            {{-- <div class="text-center"><a href="javascript:history.go(-1)">Kembali</a></div> --}}
                            <a href="{{ route('account.index') }}">Kembali ke Akun Usaha</a>
                        </div>
                    </div>
                </div>
            @endif


        </div>
    </div>
@endsection
