<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

use App\Models\Transaction;
use App\Models\Order_Paket;

use Midtrans\Config;
use Exception;

class TransactionController extends Controller
{
    public function all(Request $request)
    {
        $id      = $request->input('id');
        $limit   = $request->input('limit', 6);
        $food_id = $request->input('food_id');
        $status  = $request->input('status');

        if ($id) {

            //relasi ke foot, user
            $transaction = Transaction::with(['food','user'])->find($id);

            if ($transaction) {
                return ResponseFormatter::success(
                    $transaction,
                    'Data Transaksi Berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Transaksi Tidak Tersedia',
                    404
                );
            }
        }

        $transaction = Transaction::with(['food','user'])
            ->where('user_id', Auth::user()->id);

        if($food_id){
            $transaction->where('food_id', $food_id);
        }

        if($status){
            $transaction->where('status', $status);
        }


        return ResponseFormatter::success(
            $transaction->paginate($limit),
            'Data List Transaksi Berhasil diambil'
        );
    }

    public function update(Request $request, $id)
    {
        $transaction = Order_Paket::findOrFail($id);
        $transaction->update($request->all());

        return ResponseFormatter::success(
            $transaction,
            'Transaksi Berhasil di-Update'
        );
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'food_id'   => 'required|exists:food,id',
            'user_id'   => 'required|exists:users,id',
            'quantity'  => 'required',
            'total'     => 'required',
            'status'    => 'required',
        ]);

        $transaction = Transaction::create([
            'food_id'   => $request->food_id,
            'user_id'   => $request->user_id,
            'quantity'  => $request->quantity,
            'total'     => $request->total,
            'status'    => $request->status,
            'payment_url' => '',
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        // panggil transaksi
        $transaction = Transaction::with(['food','user'])->find($transaction->id);

        // Membuat Transaksi Midtrans
        $midtrans = [
            "transaction_details" => [
                "order_id" => $transaction->id,
                "gross_amount" => (int) $transaction->total,
            ],

            'customer_details' => [
                "first_name" => $transaction->user->name,
                "email"      => $transaction->user->email,
                "phone"      => $transaction->user->phoneNumber,
            ],

            'enabled_payments' => ["bank_transfer", "gopay"],

            'vtweb' => ['midtrans/success','midtrans/unfinish','midtrans/error']
        ];

        // Memanggil Midtrans
        try {
            // ke halaman payment midtrans
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;

            //update data
            $transaction->payment_url = $paymentUrl;
            $transaction->save();

            // Mengembalikan Data ke API
            return ResponseFormatter::success($transaction, 'Transaksi Berhasil');

        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Transaksi Gagal');
        }

    }
}
