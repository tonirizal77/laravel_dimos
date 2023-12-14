<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Midtrans\Config;
use Midtrans\Snap;

use Exception;

use App\Models\Order_Paket;
use App\Models\Paket;
use App\Models\Usaha;

class OrderPaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $order = Order_Paket::with(['paket'])
            ->orderBy('id','desc')
            ->where('usaha_id', Auth::user()->usaha_id)
            ->get();
        return response()->json(['orders' => $order]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $paket = $request->paketName;
        $paketId = $request->paketId;
        $durasi = $request->durasi;
        $total = $request->biaya;
        $no_order = 'P'.$paketId .'-'. strtoupper(Str::random(7));
        // $tgl_awal = date('Y-m-d', strtotime(\Carbon\Carbon::now()));
        // $tgl_akhir =  date('Y-m-d', strtotime($tgl_awal . ' + ' . $durasi . ' months'));

        // buat Order
        $order = new Order_Paket;
        $order->order_no        = $no_order;
        $order->paket_id        = $paketId;
        $order->usaha_id        = Auth::user()->usaha_id;
        $order->durasi          = $durasi;
        $order->total           = $total;
        $order->order_status    = '1';
        $order->save();

        $usaha = Usaha::with(['kota'])->where('id', $order->usaha_id)->first();
        $paket = Paket::find($order->paket_id);

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // // Set your Merchant Server Key for dinamis server key
        // \Midtrans\Config::$serverKey = 'YOUR_SERVER_KEY';
        // // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        // \Midtrans\Config::$isProduction = false;
        // // Set sanitization on (default)
        // \Midtrans\Config::$isSanitized = true;
        // // Set 3DS transaction for credit card to true
        // \Midtrans\Config::$is3ds = true;


        // Required
        $transaction_details = array(
            'order_id' => $order->order_no,
            'gross_amount' => $order->total, // no decimal allowed for creditcard
        );

        // Optional
        $item1_details = array(
            'id' => $paket->id,
            'price' => $paket->biaya,
            'quantity' => $order->durasi,
            'name' => "Paket-".$paket->name
        );
        $item_details = array($item1_details);

        // Optional
        $billing_address = array(
            'first_name'    => $usaha->nama,
            'address'       => $usaha->alamat,
            'city'          => $usaha->kota->name,
            'postal_code'   => $usaha->kota->postal_code,
            'phone'         => $usaha->telpon,
        );

        // Optional
        $shipping_address = array(
            'first_name'    => $usaha->nama,
            'address'       => $usaha->alamat,
            'city'          => $usaha->kota->name,
            'postal_code'   => $usaha->kota->postal_code,
            'phone'         => $usaha->telpon,
        );

        // Optional
        $customer_details = array(
            'first_name'    => $usaha->nama,
            'email'         => $usaha->email,
            'phone'         => $usaha->telpon,
            'billing_address'  => $billing_address,
            'shipping_address' => $shipping_address
        );

        // Optional, remove this to display all available payment methods
        $enable_payments = array('credit_card','cimb_clicks','mandiri_clickpay','echannel');

        // optional, save card
        $credit_card = array(
            'secure' => true,
            'save_card' => true,
        );

        $time = time();
        $custom_expire = [
            'start_time' => date('Y-m-d H:i:s +0700', $time),
            'unit' => 'minute',
            'duration' => 2,

        ];

        // Fill transaction details
        $transaction = array(
            // 'enabled_payments' => $enable_payments,
            'credit_card' => $credit_card,
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
            // 'expiry' => $custom_expire,
        );

        // return dd($transaction);

        $snapToken = Snap::getSnapToken($transaction);

        $order->snap_token = $snapToken;
        $order->save();

        if ($order){
            // response
            return response()->json([
                'pesan' =>  [
                    'status' => 'success',
                    'ket' => 'Order Paket Berhasil di-Simpan'
                ],
                'data' =>  $order,
            ]);
        } else {
            // response
            return response()->json([
                'pesan' =>  [
                    'status' => 'error',
                    'ket' => 'Order Paket Gagal di-Simpan'
                ],
            ]);
        }
    }
}
