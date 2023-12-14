<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Supplier;
use App\Models\Product;
use App\Models\Satuan;
use App\Models\Nota_Beli;
use App\Models\Data_Beli;
use App\Models\Hutang;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $px = Auth::user()->access_key.'_';
        $supplier = DB::table($px.'suppliers')->orderBy('nama','asc')
        ->leftJoin('cities', $px.'suppliers.kota_id','=','cities.id')
        ->select($px.'suppliers.*', 'cities.name as kota')
        ->get();

        // $product = Product::orderBy('id','asc')->get();

        $satuan = DB::table($px.'satuans')->orderBy('tipe','asc')->get();

        return view("ui_admin.pages.transaction.pembelian",[
            'supplier'=>$supplier,
            // 'product'=>$product,
            'satuan'=>$satuan
        ]);
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
        // function addDate($date, $day) //add days
        // {
        //     $sum = strtotime(date("Y-m-d", strtotime("$date")) . " +$day days");
        //     $dateTo = date('Y-m-d', $sum);
        //     return $dateTo;
        // }

        $px = Auth::user()->access_key.'_';

        $user_id = Auth::user()->id;

        $split 	   = explode('-', $request->tanggal);
        $tgl_2_ymd = date($split[2] . '-' . (int)$split[1] . '-' . $split[0]);

        // *1
        $no_nota = $request->nomor_nota; //nomor sementara
        $tgl_nota = $tgl_2_ymd;
        $supplier_id = $request->supplier;

        // cek nota terakhir
        $nota_beli = DB::table($px.'nota_beli')->orderBy('id', 'desc')->first();

        // $tgl_skrg = date('d-m-y'); // 01-01-21
        $tgl_input = date('d-m-y', strtotime($request->tanggal) ); // 01-01-21
        $tgl = implode("", explode("-",$tgl_input));

        // update nomor nota
        if ($nota_beli == null) {
            $no_nota = 'NB-' .$tgl. '-0001';
        } else {
            $nomor = ((int)substr($nota_beli->no_nota,10,4))+1;
            $no_nota = 'NB-' .$tgl.'-'.sprintf("%04s", $nomor);
        }

        // rincian data
        $arr_kode = $request->kode_brg;
        $arr_harga = $request->harga_brg;
        $arr_sat = $request->satuan;
        $arr_qty = $request->qty_beli;

        // *2 Bayar
        $tunai = (double)implode(preg_split('[,]', $request->byrCash));
        $kartu = (double)implode(preg_split('[,]', $request->byrCard));
        $kredit = (double)implode(preg_split('[,]', $request->byrKredit));
        $tempo = $request->lamaTempo;

        if ($kredit > 0) {
            $tgl_tempo = date('Y-m-d', strtotime($tgl_nota . '+' . $tempo . ' days'));
        } else {
            $tempo = 0;
            $tgl_tempo = null;
        }

        // *3 Total
        $brutto = (double)implode(preg_split('[,]', $request->subTotal));
        $disc = (double)implode(preg_split('[,]', $request->discount));
        $total = (double)implode(preg_split('[,]', $request->grandTotal));

        $id = DB::table($px.'nota_beli')
        ->insertGetId([
            'no_nota'       => $no_nota,
            'tanggal'       => $tgl_nota,
            'supplier_id'   => $supplier_id,
            'brutto'        => $brutto,
            'disc'          => $disc,
            'total'         => $total,
            'tunai'         => $tunai,
            'kredit'        => $kredit,
            'kartu'         => $kartu,
            'tempo'         => $tempo,
            'tgl_tempo'     => $tgl_tempo,
            'user_id'       => $user_id,
        ]);

        if ($id) {
            // save hutang
            if ($kredit > 0) {
                DB::table($px.'hutangs')->insert([
                    'supplier_id' => $supplier_id,
                    'nota_id' => $id,
                    'no_nota' => $no_nota,
                    'tanggal' => $tgl_nota,
                    'jumlah' => $kredit,
                    'status' => "1",
                    'user_id' => $user_id
                ]);
            }

            // save detail nota
            for ($i = 0; $i < count($arr_kode); $i++) {
                DB::table($px.'data_beli')->insert([
                    'nota_id' => $id,
                    'no_nota' => $no_nota,
                    'code' => $arr_kode[$i],
                    'qty' => $arr_qty[$i],
                    'satuan' => $arr_sat[$i],
                    'harga_beli' => (double)implode(preg_split('[,]', $arr_harga[$i])),
                ]);
            }
            $info = ['success' => 'Semua Data Sukses di-Simpan'];
        } else {
            $info = ['errors'   => 'Data Nota Gagal di-Simpan'];
        }

        return response()->json($info);
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
     * @param  int  $id - nota_beli
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        // return response()->json(["id" =>$id, "request" => $request]);
        $user_id = Auth::user()->id;
        $px = Auth::user()->access_key.'_';

        $today = \Carbon\Carbon::now()->locale('id');

        //ambil data catatan hutang lama
        $hutang = DB::table($px.'nota_beli')->where('id',$id)->first();

        $split 	 = explode('-', $request->tanggal);
        $tgl_2_ymd = date($split[2] . '-' . (int)$split[1] . '-' . $split[0]);

        // *1
        $no_nota = $request->nomor_nota;
        $tgl_nota = $tgl_2_ymd;
        $supplier_id = $request->supplier;

        // rincian data
        $arr_kode = $request->kode_brg;
        $arr_harga = $request->harga_brg;
        $arr_sat = $request->satuan;
        $arr_qty = $request->qty_beli;

        // *2 Bayar
        $tunai = (double)implode(preg_split('[,]', $request->byrCash));
        $kartu = (double)implode(preg_split('[,]', $request->byrCard));
        $kredit = (double)implode(preg_split('[,]', $request->byrKredit));
        $tempo = $request->lamaTempo;

        if ($kredit > 0) {
            $tgl_tempo = date('Y-m-d', strtotime($tgl_nota . '+' . $tempo . ' days'));
        } else {
            $tempo = 0;
            $tgl_tempo = null;
        }

        // *3 Total
        $brutto = (double)implode(preg_split('[,]', $request->subTotal));
        $disc = (double)implode(preg_split('[,]', $request->discount));
        $total = (double)implode(preg_split('[,]', $request->grandTotal));

        $nota_beli = DB::table($px.'nota_beli')->where("id", $id)
            ->update([
                // updated data
                // 'no_nota'       => $no_nota,
                'tanggal'       => $tgl_nota,
                'supplier_id'   => $supplier_id,
                'brutto'        => $brutto,
                'disc'          => $disc,
                'total'         => $total,
                'tunai'         => $tunai,
                'kredit'        => $kredit,
                'kartu'         => $kartu,
                'tempo'         => $tempo,
                'tgl_tempo'     => $tgl_tempo,
                'user_id'       => $user_id,
            ]);

        if ($nota_beli) {
            // cek hutang lama
            if ($hutang->kredit > 0) {

                // cek hutang sekarang
                if ($kredit == 0) {
                    // hapus lama (semua history), dan update deleted_at data terakhir
                    // $hapus_hutang = DB::table($px.'piutangs')->where('nota_id',$id)->delete();
                    $hapus_hutang = DB::table($px.'hutangs')->where('nota_id',$id)->whereNotNull('deleted_at')->delete(); //history lama
                    $hapus_hutang = DB::table($px.'hutangs')->where('nota_id',$id)->update(['deleted_at' => $today]); //history baru
                } else {
                    // update hutam lama
                    // jika ada angsuran (tetap ada)
                    DB::table($px.'hutangs')->where("nota_id", $id)->where("status","1")->whereNull('deleted_at')->update([
                       // 'nota_id' => $id,
                       // 'no_nota' => $no_nota,
                        'supplier_id' => $supplier_id,
                        'tanggal' => $tgl_nota,
                        'jumlah' => $kredit,
                        'status' => "1", // nota baru
                        'user_id' => $user_id
                    ]);
                }
            } else {
                if ($kredit > 0) {
                    // buat hutang baru
                   DB::table($px.'hutangs')->insert([
                        'supplier_id' => $supplier_id,
                        'nota_id' => $id,
                        'no_nota' => $no_nota,
                        'tanggal' => $tgl_nota,
                        'jumlah' => $kredit,
                        'status' => "1", // nota baru
                        'user_id' => $user_id
                    ]);
                }
            }

            // save detail nota
            // hapus data lama

            // 1. delete massal non permanent (softdeletes) karna pakai model
            // $data_lama = DB::table($px.'data_jual')->where('nota_id', $id)->delete();

            // 2. delete massal permanent (softdeletes) tidak pakai model

            $data_lama = DB::table($px.'data_beli')->where('nota_id', $id)->whereNotNull('deleted_at')->delete();
            $data_lama = DB::table($px.'data_beli')->where('nota_id', $id)->update(['deleted_at'=> $today]);

            for ($x = 0; $x < count($arr_kode); $x++) {
                $hrg_b = (double)implode(preg_split('[,]', $arr_harga[$x]));

                $data_beli =  DB::table($px.'data_beli')->insert(
                    [
                        'nota_id' => $id,
                        'no_nota' => $no_nota,
                        'code' => $arr_kode[$x],
                        'qty' => $arr_qty[$x],
                        'satuan' => $arr_sat[$x],
                        'harga_beli' => $hrg_b
                    ]
                );
            }
            $info = ['success'   => 'Semua Data Sukses di-Update'];
        } else {
            $info = ['errors'   => 'Data Nota Gagal di-Update'];
        }

        // get all rincian
        $data_beli = DB::table($px.'data_beli')
            ->where('nota_id',$id)
            ->get();

        return response()->json([
            $info,
            'ID Nota' => $id,
            'data' => $data_beli,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Nota_Beli::destroy($id);
        // Data_Beli::where('nota_id', $id)->delete(); // delete massal
        // Hutang::where('nota_id', $id)->delete(); // delete massal
        // return response()->json(
        //     [
        //         'success' => 'Data Nota berhasil di-Hapus',
        //     ]
        // );
        $today = \Carbon\Carbon::now()->locale('id'); //blm sesuai dgn waktu komputer

        $px = strtolower(Auth::user()->access_key);
        $nota_beli = $px.'_'.'nota_beli';
        $data_beli = $px.'_'.'data_beli';
        $hutang   = $px.'_'.'hutangs';

        DB::table($nota_beli)->where('id', $id)->whereNull('deleted_at')->update(['deleted_at'=> $today]); //::destroy($id);
        DB::table($data_beli)->where('nota_id', $id)->whereNull('deleted_at')->update(['deleted_at'=> $today]); // delete massal sementara
        DB::table($hutang)->where('nota_id', $id)->whereNull('deleted_at')->update(['deleted_at'=> $today]); // delete massal sementara
        return response()->json(
            [
                'pesan' => "success",
                'isi_pesan' => 'Data Nota berhasil di-Hapus'
            ]
        );
    }

    /**
     * Request Nomor Transaksi
     * Nota Pembelian Terakhir
     */
    public function getNoTrx()
    {
        $table = strtolower(Auth::user()->access_key).'_'.'nota_beli';

        $nota = DB::table($table)->orderBy('id','desc')->first();
        $no_trx = "";
        $hariIni = \Carbon\Carbon::now()->locale('id');

        $tgl_skrg = date('d-m-y'); // 01-01-21
        $tgl = implode("", explode("-",$tgl_skrg));

        if ($nota == null) {
            $no_trx = 'NB-' .$tgl. '-0001';
        } else {
            $no_trx = 'NB-' .$tgl.'-'.sprintf("%04s", (($nota->id)+1));
        }

        return response()->json(['no_trx'=>$no_trx, 'tgl now' => $hariIni ]);
    }

    /** load Nota Beli ajax */
    public function loadNotaBeli(Request $request, $id){

        $px = Auth::user()->access_key.'_';
        $range = $request->tgl_aw .' s/d '. $request->tgl_ak;

        $nota_beli = DB::table($px.'nota_beli')->orderBy('no_nota','asc')
            ->leftJoin($px.'suppliers as supl', $px.'nota_beli.supplier_id','=','supl.id')
            ->leftJoin('users as user', $px.'nota_beli.user_id','=','user.id')
            ->select($px.'nota_beli.*','user.name as nama_user','supl.nama as nama_supplier')
            ->whereBetween('tanggal', [$request->tgl_aw, $request->tgl_ak]);

        if ($id === "true") {
            // tampilkan data yang dihapus
            $nota_beli = $nota_beli->get();
            // $nota_beli = "tampilkan hapus";
        } else {
            // lewati data yang dihapus
            $nota_beli = $nota_beli->whereNull($px.'nota_beli.deleted_at')->get();
            // $nota_beli = "jangan tampilkan hapus";
        }

        return Response()->json(['data' => $nota_beli, 'periode:' => $range]);
    }

    /** load Data Beli ajax */
    public function loadDataBeli($id){

        $px = Auth::user()->access_key.'_';

        $data_beli = DB::table($px.'data_beli')->orderBy('nota_id','asc')
            ->leftJoin($px.'products as prod', $px.'data_beli.code','=','prod.code')
            ->select($px.'data_beli.*', 'prod.name as nama_barang')
            ->where("nota_id",$id)
            ->whereNull($px.'data_beli.deleted_at')
            ->get(); //array

        $nota_beli = DB::table($px.'nota_beli')->orderBy('id','asc')
            ->where("id",$id)
            ->first(); //not array

        return Response()->json([
            'data' => $data_beli,
            'nota' => $nota_beli,
        ]);
    }
}

