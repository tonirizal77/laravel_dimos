<?php

namespace App\Http\Controllers;

use App\Models\Sesijual;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SesijualController extends Controller
{


    public function index()
    {
        //seleksi sesuai user aktif dan bulan berjalan (belum)
        $table = strtolower(Auth::user()->access_key).'_'.'sesijuals';
        // $table = 'sesijuals';
        $data = Sesijual::from($table)
            ->orderBy('tanggal','asc')
            ->with(['user'])
            ->where('user_id', Auth::user()->id)
            ->get();

        return response()->json(['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $table = strtolower(Auth::user()->access_key).'_'.'sesijuals';

        $kode_sesi = $request->kode_sesi;
        $kassa = $request->kassa;
        $kasir_id = $request->kasir;
        $shift = $request->shift;
        $tgl = $request->tgl_sesi;
        $kas = (double)implode(preg_split('[,]', $request->kas));

        $tgl_s = date("Y-m-d", strtotime($tgl));

        $sesijual = Sesijual::from($table)
            ->insert([
                'kode_sesi' => $kode_sesi,
                'tanggal'   => $tgl_s,
                'user_id'   => $kasir_id,
                'kas_awal'  => $kas
            ]);

        if ($sesijual) {
            $info = [
                'pesan' => 'success',
                'isi_pesan' => 'Sesi Jual Sukses di-Simpan',
            ];
        } else {
           $info = [
                'pesan' => 'error',
                'isi_pesan' => 'Sesi Jual Gagal di-Simpan',
            ];
        }

        $sesi_baru = Sesijual::from($table)
            ->where("kode_sesi", $kode_sesi)
            ->leftJoin("users", $table.'.user_id','users.id')
            ->select( $table.'.*', 'users.name as nama_kasir' )
            ->first();

        return response()->json([
            'info' => $info,
            'data' => $sesi_baru,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sesijual  $sesijual
     * @return \Illuminate\Http\Response
     */
    public function show(Sesijual $sesijual)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sesijual  $sesijual
     * @return \Illuminate\Http\Response
     */
    public function edit(Sesijual $sesijual)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sesijual  $sesijual
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sesijual $sesijual)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sesijual  $sesijual
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sesijual $sesijual)
    {
        //
    }

    public function cekSesi(Request $request) {
        $table = strtolower(Auth::user()->access_key).'_'.'sesijuals';
        $cari = Sesijual::from($table)
            ->where('kode_sesi', '=', $request->kode_sesi)
            ->exists(); // menghasilkan 1 / 0 (true/false)

        /**info versi cek */
        // $data = "";
        // $info = "";
        if ($cari) {
            return response()->json(false);
            // $info = "nama sudah ada"; // user found
            // $data = Sesijual::where('kode_sesi', '=', $request->kode_sesi)->first();
        } else {
            return response()->json(true);
            // $info = "nama belum ada"; // user not found
        }
        // return response()->json(['data'=>$data, 'status'=> $cari ,'message'=>$info]);
    }

    /**load sesijual */
    public function getSesiJual(Request $request){
        $table = strtolower(Auth::user()->access_key).'_'.'sesijuals';
        // $table = 'sesijuals';

        $sesi_jual = Sesijual::from($table)->with(['user'])
            ->where("kode_sesi","=", $request->kode_sesi)
            ->first();

        if ($sesi_jual == null) {
            $no_trx = $request->kode_sesi . '-001';
        } else {
            $no_trx = $request->kode_sesi . '-' . sprintf("%03s", (($sesi_jual->no_trx)+1));
        }

        return response()->json(['no_trx'=>$no_trx, 'data' => $sesi_jual]);

    }
}


// rangkai kode_sesi (manual)
// $changeDate = date("d-m-y", strtotime($tgl));
// $tgl_x = implode("", explode("-",$changeDate));
// $kode_sesi = $shift . $kassa .'-'. $tgl_x  ;

// $sesijual = Sesijual::create([
//     'kode_sesi' => $kode_sesi,
//     'tanggal'   => $tgl_s,
//     'user_id'   => $kasir_id,
//     'kas_awal'  => $kas
// ]);
// $sesijual = Sesijual::from($table)

// $nota = Nota_Jual::withTrashed()->orderBy('id','desc')
//     ->where(Str::limit('no_nota',9),'=',$kode_sesi)->first();

// $no_trx = "";
// $hariIni = \Carbon\Carbon::now()->locale('id');

// $tgl_skrg = date('d-m-y'); // 01-01-21
// $tgl = implode("", explode("-",$tgl_skrg));

