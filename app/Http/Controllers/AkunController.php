<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Akun;
use App\Models\History_Akun;
use App\Models\Usaha;
use App\Models\Paket;
use App\Models\User;
use App\Models\Order_Paket;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {

            $paket = Paket::all();

            // last akun aktif
            $akun = Akun::orderBy('id','desc')
                ->where('usaha_id', Auth::user()->usaha_id)
                ->where('status', 1)
                ->first();

            return view('ui_admin.pages.lain-lain.akun_usaha',[
                'paket' => $paket,
                'akun_aktif' => $akun // tidak dipakai
            ]);

        } else {
            return redirect()->route('dashboard.index');
        }


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

        $tgl_awal = date('Y-m-d', strtotime(\Carbon\Carbon::now()));
        $durasi = $request->durasi;
        $tgl_akhir =  date('Y-m-d', strtotime($tgl_awal . ' + ' . $durasi . ' months'));

        // return response()->json([
        //     'tgl_awal' => $tgl_awal,
        //     'tgl_akhir' => $tgl_akhir,
        //     'durasi' => $durasi,
        // ]);

        //Convert Tanggal (dd/mm/yyyy) to (Y-m-d)
        // $tgl = str_replace('/', '-', $request->startDate);
        // $start = date('Y-m-d', strtotime($tgl));
        // $tgl_sblm = date('Y-m-d', strtotime('-1 days', strtotime( $start )));

        $paket = $request->paketName;

        $akun = new Akun;
        $akun->usaha_id    = Auth::user()->usaha_id;
        $akun->paket_id    = $request->paketId;
        $akun->status      = "2"; //Suspend(ditahan)
        $akun->biaya       = $request->biaya;
        $akun->keterangan  = "Menunggu Pembayaran";
        $akun->durasi      = $request->durasi;
        $akun->start_date  = $tgl_awal;
        $akun->expire_date = $tgl_akhir;
        $sukses            = $akun->save();

        if ($sukses){
            // buat history
            // $history = History_Akun::create([
            //     'akuns_id'    => $akun->id,
            //     'usaha_id'    => Auth::user()->usaha_id,
            //     'keterangan'  => "Akun Baru, ".$paket.", ".$durasi." bulan, Menunggu Pembayaran.",
            //     'action'      => '1',
            //     'action_link' => 'link to Gateway Payment'
            // ]);
            // response
            return response()->json([
                'pesan' =>  [
                    'status' => 'success',
                    'ket' => 'Akuns Paket Berhasil di-Simpan'
                ],
            ]);
        } else {
            // response
            return response()->json([
                'pesan' =>  [
                    'status' => 'error',
                    'ket' => 'Akuns Paket Gagal di-Simpan'
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function loadAkunUsaha() {
        $akun = Akun::where('usaha_id', Auth::user()->usaha_id)->with(['paket'])->first();
        $usaha = Usaha::find(Auth::user()->usaha_id);
        return response()->json(['akun' => $akun, 'usaha' => $usaha]);
    }



}
