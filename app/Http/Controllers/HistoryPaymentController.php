<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\History_Payment;

class HistoryPaymentController extends Controller
{
    public function store(Request $request)
    {
        $result = json_decode($request->result);
        History_Payment::create([
            'order_no' => $request->orderNo,
            'keterangan' => $request->result
        ]);

        return response()->json([
            'pesan' => [
                   'tipe' => 'success',
                   'info' => 'Sukses Simpan History Payment',
            ],
            'result' => $result

        ]);
    }
}
