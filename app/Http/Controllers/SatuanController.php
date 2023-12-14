<?php

namespace App\Http\Controllers;

use App\Models\Satuan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SatuanController extends Controller
{
    /** load data ajax */
    public function loadDataAjax(){
        $px = Auth::user()->access_key."_";
        $satuan = DB::table($px.'satuans')->orderBy('tipe','asc')->get();
        return Response()->json(['data'=>$satuan]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ui_admin.pages.master-data.satuans_list');
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
        $table = Auth::user()->access_key."_satuans";

        $kode_arr = $request->check_satuan;
        $satuan_arr = explode('.', $request->kode_satuan);
        $nilai_arr = explode('.', $request->nilai_satuan);

        if ($request->jenis_satuan == 1) {
            array_push( $kode_arr, "K" ); // sisipkan array baru
        }

        $satuan = Satuan::from($table)->insert([
            'tipe'      => $request->kode_satuan,
            'konversi'  => $request->jenis_satuan,
            'nilai'     => $request->nilai_satuan,
            'kode'      => implode(".", $kode_arr),
            // 'usaha_id'  => Auth::user()->usaha_id,
        ]);

        if($satuan) {
            return response()->json([
                'info' => [
                    'status' => 'success',
                    'pesan' => 'Data Satuan Berhasil di-Tambahkan',
                ],
                'data' => $satuan,
            ]);
        } else {
            return response()->json([
                'info' => [
                    'status' => 'error',
                    'pesan' => 'Data Satuan Berhasil di-Tambahkan',
                ],
                'data' => $satuan,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function show(Satuan $satuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function edit(Satuan $satuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $satuan->id;
        $px = Auth::user()->access_key."_";
        $kode_arr = $request->check_satuan;

        if ($request->jenis_satuan == 1) {
            array_push( $kode_arr, "K" );
        }

        $satuan =  DB::table($px.'satuans')->where('id', $id)->first();
        DB::table($px.'products')->where('sat_konversi', $satuan->tipe)
        ->update([
            'sat_konversi' => $request->kode_satuan,
        ]);

        DB::table($px.'satuans')->where('id', $id)
            ->update([
                'tipe'      => $request->kode_satuan,   // BALL.TIM.KG-10.5.1
                'konversi'  => $request->jenis_satuan,  // 0/1
                'nilai'     => $request->nilai_satuan,  // 10.5.1
                'kode'      => implode(".", $kode_arr), // B.S.K
            ]);

        return response()->json([
            'info' => [
                'status' => 'success',
                'pesan' => 'Data Satuan Berhasil di-Update'
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Satuan  $satuan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tb = Auth::user()->access_key.'_satuans';

        // Satuan::from($tb)->where('id', $id)->delete();

        Satuan::from($tb)->where('id', $id)->update([
            'deleted_at' => \Carbon\Carbon::now()
        ]);

        return response()->json([
            'success' => 'Data Satuan berhasil di-Hapus',
        ]);
    }

    public function cekTipe(Request $request) {
        $opr  = $request->opr; //edit or tambah
        $lama = $request->kodelama;
        $kode = $request->kode_satuan;

        $px = Auth::user()->access_key.'_';

        $cari = DB::table($px.'satuans')
            ->where('tipe', '=',  $kode)
            ->exists(); // menghasilkan 1 / 0 (true/false)

        /**info versi cek */
        // $info = "";

        if ($cari) {
            if ($opr == 'tambah') {
                return response()->json(false); // invalid
            } else {
                if ($lama ==  $kode) {
                    return response()->json(true); // abaikan
                } else {
                    return response()->json(false); // invalid
                }
            }
            // $info = "nama sudah ada"; // satuan found
        } else {
            return response()->json(true); // valid
            // $info = "nama belum ada"; // satuan not found
        }

        // return response()->json([
        //     'status'=> $cari ,
        //     'message'=>$info,
        //     'opr'=>$opr,
        //     'lama'=>$lama
        // ]);
    }
}
