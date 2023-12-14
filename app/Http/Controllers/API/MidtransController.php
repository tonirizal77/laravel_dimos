<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DatabaseClientController;
use Illuminate\Http\Request;

use Midtrans\Config;
use Midtrans\Notification;

use App\Models\Order_Paket;
use App\Models\History_Payment;
use App\Models\Usaha;
use App\Models\Paket;
use App\Models\Akun;

class MidtransController extends Controller
{
    public function callback(Request $request)
    {
        $payload = $request->getContent();
		$notification = json_decode($payload);

		$validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . config('services.midtrans.serverKey'));

		if ($notification->signature_key != $validSignatureKey) {
            return response(['message' => 'Invalid signature'], 403);
		}

        // set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // Buat instance midtrans notification
        $notif = new Notification(); // or \Midtrans\Notification();

        // dd($notif);

        // assign ke variable untuk memudahkan koding
        $status   = $notif->transaction_status;
        $type     = $notif->transaction_type;
        $fraud    = $notif->fraud_status;
        $order_id = $notif->order_id;
        $total    = $notif->gross_amount;

        // cari transaksi berdasarkan id
        $transaction = Order_Paket::where('order_no', $order_id)->first();

        // handel notifikasi status dari midtrans
        if ($status == 'capture') {
            if ($type == 'credit_card'){
                if ($fraud == 'challenge') {
                    $transaction->order_status = "1";
                    $transaction->payment_status = "1";
                } else if ($fraud == 'accept') {
                    $transaction->order_status = "2";
                    $transaction->payment_status = "2";
                }
            }
        }
        else if ($status == 'settlement') {
            $transaction->order_status = "2";
            $transaction->payment_status = "2";
        }
        else if ($status == 'pending') {
            $transaction->order_status = "1";
            $transaction->payment_status = "1";
        }
        else if ($status == 'cancel') {
            $transaction->order_status = "3";
            $transaction->payment_status = "3";
        }
        else if ($status == 'deny') {
            $transaction->order_status = "3";
            $transaction->payment_status = "5";
        }
        else if ($status == 'expire') {
            $transaction->order_status = "3";
            $transaction->payment_status = "4";
        }

        // update status transaksi order_paket
        $transaction->save();

        if ($transaction->payment_status == '2') {
            // tambah data akun
            $tgl_awal = date('Y-m-d', strtotime(\Carbon\Carbon::now()));
            $durasi = $transaction->durasi;
            $tgl_akhir =  date('Y-m-d', strtotime($tgl_awal . ' + ' . $durasi . ' months'));

            $akun = Akun::updateOrCreate(
                [   'usaha_id' => $transaction->usaha_id ],
                [
                    'paket_id'  => $transaction->paket_id,
                    'order_no'  => $transaction->order_no,
                    'biaya'     => $transaction->total,
                    'durasi'    => $transaction->durasi,
                    'status'    => "1",
                    'keterangan' => "Akun Usaha Aktif",
                    'start_date' => $tgl_awal,
                    'expire_date' => $tgl_akhir,
                ]
            );

            $usaha = Usaha::where('id', $transaction->usaha_id)->update([
                'status' => '1',
                'status_akun' => '1',
            ]);

            // tambah data history payment
            History_Payment::create([
                'order_no' => $order_id,
                'keterangan' => json_encode($notification)
            ]);

            // Buat Database Client
            // return redirect()->action([DatabaseClientController::class]);

        } elseif ($transaction->payment_status != '1' && $transaction->payment_status != '2' ){

            // di-cancel by merchant/system
            History_Payment::create([
                'order_no' => $order_id,
                'keterangan' => json_encode($notification)
            ]);

            $akun = Akun::updateOrCreate(
                [   'usaha_id' => $transaction->usaha_id ],
                [
                    'paket_id'  => $transaction->paket_id,
                    'order_no'  => $transaction->order_no,
                    'biaya'     => $transaction->total,
                    'durasi'    => $transaction->durasi,
                    'status'    => "3",
                    'keterangan' => "Akun Usaha Tidak Aktif",
                ]
            );

            $usaha = Usaha::where('id', $transaction->usaha_id)->update([
                'status' => '0',
                'status_akun' => '0',
            ]);
        }

        // if ($transaction){
        //     return response()->json([
        //         'notification' => 'update status success',
        //         'data' => $transaction,
        //         'request' => $notification,
        //     ]);
        // }
    }

    public function success(Request $request)
    {
        $order = Order_Paket::where('order_no', $request->order_id)->first();

        if ($order != null) {
            $customer = Usaha::where('id', $order->usaha_id)->with(['kota','province'])->first();
            $items = Paket::where('id', $order->paket_id)->first();
            $history = History_Payment::orderBy('id', 'desc')->where('order_no', $request->order_id)->first();
            $data = [
                'order' => $order,
                'customer' => $customer,
                'items' => $items,
                'history' => json_decode($history->keterangan)
                // 'history' => $history
            ];
        } else {
            $data = null;
        }

        // dd($data);

        return view('ui_admin.pages.midtrans.success',['data' => $data] );
    }

    public function unfinish(Request $request)
    {
        $order = Order_Paket::where('order_no', $request->order_id)->first();

        if ($order != null) {
            $customer = Usaha::where('id', $order->usaha_id)->with(['kota','province'])->first();
            $items = Paket::where('id', $order->paket_id)->first();
            $history = History_Payment::orderBy('id', 'desc')->where('order_no', $request->order_id)->first();
            $data = [
                'order' => $order,
                'customer' => $customer,
                'items' => $items,
                'history' => json_decode($history->keterangan)
                // 'history' => $history
            ];
        } else {
            $data = null;
        }

        // dd($data);

        return view('ui_admin.pages.midtrans.success',['data' => $data] );
    }

    public function error(Request $request)
    {
        $order = Order_Paket::where('order_no', $request->order_id)->first();

        if ($order != null) {
            $customer = Usaha::where('id', $order->usaha_id)->with(['kota','province'])->first();
            $items = Paket::where('id', $order->paket_id)->first();
            $history = History_Payment::orderBy('id', 'desc')->where('order_no', $request->order_id)->first();
            $data = [
                'order' => $order,
                'customer' => $customer,
                'items' => $items,
                'history' => json_decode($history->keterangan)
                // 'history' => $history
            ];
        } else {
            $data = null;
        }

        // dd($data);

        return view('ui_admin.pages.midtrans.success',['data' => $data] );
    }
}



