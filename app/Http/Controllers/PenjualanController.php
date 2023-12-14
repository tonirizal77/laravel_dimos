<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

// use App\Models\Supplier;
// use App\Models\Product;
// use App\Models\Satuan;
// use App\Models\Nota_Jual;
// use App\Models\Data_Jual;
// use App\Models\Piutang;
// use App\Models\Sesijual;
use App\Models\User;
use App\Models\Usaha;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kasir = User::orderBy("name","asc")
            ->where("usaha_id", Auth::user()->usaha_id)
            ->where("role_id", "3")
            ->where('active', 1)
            ->get();

        return view("ui_admin.pages.transaction.pos_kasir2", ['kasir' => $kasir]);
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

        // return $request;

        $px = Auth::user()->access_key.'_';

        $user_id = Auth::user()->id;

        $split 	   = explode('-', $request->tanggal);
        $tgl_2_ymd = date($split[2] . '-' . (int)$split[1] . '-' . $split[0]);

        // *1
        $no_nota = $request->nomor_nota; //nomor sementara
        $tgl_nota = $tgl_2_ymd;
        $customer_id = $request->customer;

        $kode_sesi = substr($no_nota,0,9);

        // rincian data
        $arr_kode = $request->kode_brg;
        $arr_harga = $request->harga_brg;
        $arr_modal = $request->hrg_modal;
        $arr_sat = $request->satuan;
        $arr_qty = $request->qty_jual;
        $arr_disc = $request->disc;

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

        // cek nota terakhir
        $nota_jual = DB::table($px.'nota_jual')->orderBy('no_nota', 'desc')
            ->where('no_nota', 'like', $kode_sesi . '%')
            ->first();

        if ($nota_jual != null){
            $nomor = ((int)substr($nota_jual->no_nota,11,3))+1;
            $no_nota = $kode_sesi . '-' . sprintf("%03s", $nomor);
        } else {
            $no_nota = $kode_sesi . '-001';
            $nomor = 1;
        }

        $isi_pesan = [];

        $new_nota_id = DB::table($px.'nota_jual')
        ->insertGetId([
            'no_nota'       => $no_nota,
            'tanggal'       => $tgl_nota,
            'customer_id'   => $customer_id,
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

        if ($new_nota_id) {
            array_push($isi_pesan, "Nota Baru di-Buat");

            // cek sesijual & update
            DB::table($px.'sesijuals')->where('kode_sesi', $kode_sesi)->update(['no_trx' => $nomor]);
            array_push($isi_pesan, "No-Trx Sesijual di-update");

            // save piutang customer
            if ($kredit > 0) {
                DB::table($px.'piutangs')
                ->insert([
                    'customer_id' => $customer_id,
                    'nota_id' => $new_nota_id,
                    'no_nota' => $no_nota,
                    'tanggal' => $tgl_nota,
                    'jumlah' => $kredit,
                    'status' => "1",
                    'user_id' => $user_id
                ]);
                array_push($isi_pesan, "Piutang di-Buat");
            }

            // save detail nota
            $ok = false;
            $data_jual = DB::table($px.'data_jual');
            for ($i = 0; $i < count($arr_kode); $i++) {
                $data_jual->insert([
                    'nota_id' => $new_nota_id,
                    'no_nota' => $no_nota,
                    'code' => $arr_kode[$i],
                    'qty' => $arr_qty[$i],
                    'satuan' => $arr_sat[$i],
                    'disc' => (double)implode(preg_split('[,]', $arr_disc[$i])),
                    'harga_jual' => (double)implode(preg_split('[,]', $arr_harga[$i])),
                    'harga_beli' => (double)implode(preg_split('[,]', $arr_modal[$i]))
                ]);
                $ok = true;
            }

            if($ok) {
                array_push($isi_pesan, "Transaksi Sukses di-Simpan");
                $info = [
                    'pesan' => 'success',
                    'isi_pesan' => $isi_pesan,
                ];
            } else {
                array_push($isi_pesan, 'Rincian Nota Gagal di-Simpan');
                $info = [
                    'pesan' => 'error',
                    'isi_pesan' => $isi_pesan,
                ];
            }
        } else {
            array_push($isi_pesan, 'Data Nota Gagal di-Simpan');
            $info = [
                'pesan' => 'error',
                'isi_pesan' => $isi_pesan,
            ];
        }

        // Cetak Struk
        // 1-Data Usaha
        // 2-Nota dan Rincian

        $usaha = Usaha::where('id', Auth::user()->usaha_id)->with(['kota'])->first();

        $id = $new_nota_id;

        $nota_jual = DB::table($px.'nota_jual')
            ->where($px.'nota_jual.id', $id)
            ->leftJoin('users as cust',$px.'nota_jual.customer_id','=','cust.id')
            ->leftJoin('cities','cust.cities_id','=','cities.id')
            ->select($px.'nota_jual.*','cust.name as cust_name','cities.name as kota')
            ->first();

        $data_jual = DB::table($px.'data_jual')
            ->where($px.'data_jual.nota_id', $id)
            ->whereNull($px.'data_jual.deleted_at')
            ->leftJoin($px.'products as prod', $px.'data_jual.code','=','prod.code')
            ->select($px.'data_jual.*', 'prod.name as nama_barang')
            ->get();

        return response()->json([
            'info' => $info,
            'nota' => $nota_jual,
            'data' => $data_jual,
            'usaha' => $usaha,
        ]);
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
        // return $request;
        // return response()->json(["id" =>$id, "request" => $request]);

        // $px = (Auth::user()->access_key !=null) ? Auth::user()->access_key.'_' : "";
        $px = Auth::user()->access_key.'_';

        $user_id = Auth::user()->id;

        $today = \Carbon\Carbon::now()->locale('id');

        //ambil data catatan hutang lama
        $nota_jual = DB::table($px.'nota_jual')->where('id', $id)->first(); //not array
        $hutang_lama = $nota_jual->kredit;

        $split 	 = explode('-', $request->tanggal);
        $tgl_2_ymd = date($split[2] . '-' . (int)$split[1] . '-' . $split[0]);

        // *1
        $no_nota = $request->nomor_nota;
        $tgl_nota = $tgl_2_ymd;
        $customer_id = $request->customer;

        // rincian nota
        $arr_kode = $request->kode_brg;
        $arr_qty = $request->qty_jual;
        $arr_sat = $request->satuan;
        $arr_harga = $request->harga_brg;
        $arr_modal = $request->hrg_modal;
        $arr_disc = $request->disc;

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

        $isi_pesan = [];

        $nota_jual = DB::table($px.'nota_jual')->where('id', $id)->update([
            'no_nota'       => $no_nota,
            'tanggal'       => $tgl_nota,
            'customer_id'   => $customer_id,
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

        // jika data yg diupdate nilainya sama persis,
        // maka update data gagal

        if ($nota_jual) {
            array_push($isi_pesan, "Nota di-Update");
            // cek hutang lama
            if ($hutang_lama > 0) {
                // cek hutang sekarang
                if ($kredit == 0) {
                    // hapus lama (semua history), dan update deleted_at data terakhir
                    // $hapus_hutang = DB::table($px.'piutangs')->where('nota_id',$id)->delete();
                    $hapus_hutang = DB::table($px.'piutangs')->where('nota_id',$id)->whereNotNull('deleted_at')->delete();
                    $hapus_hutang = DB::table($px.'piutangs')->where('nota_id',$id)->update(['deleted_at' => $today]);

                    array_push($isi_pesan, "Hutang Lama di-Hapus");
                } else {
                    // update hutang lama
                    // jika ada angsuran (tetap ada)

                    DB::table($px.'piutangs')->where("nota_id", $id)->where("status","1")->whereNull('deleted_at')->update([
                        'customer_id' => $customer_id,
                        'nota_id' => $id,
                        'no_nota' => $no_nota,
                        'tanggal' => $tgl_nota,
                        'jumlah' => $kredit,
                        'status' => "1",
                        'user_id' => $user_id
                    ]);
                    array_push($isi_pesan, "Hutang Lama di-Update");
                }
            } else {
                if ($kredit > 0) {
                    // buat hutang baru
                    DB::table($px.'piutangs')->insert([
                        'customer_id' => $customer_id,
                        'nota_id' => $id,
                        'no_nota' => $no_nota,
                        'tanggal' => $tgl_nota,
                        'jumlah' => $kredit,
                        'status' => "1",
                        'user_id' => $user_id
                    ]);
                    array_push($isi_pesan, "Hutang Baru di-Buat");
                }
            }

            // save detail nota
            // hapus data lama

            // 1. delete massal non permanent (softdeletes) karna pakai model
            // $data_lama = DB::table($px.'data_jual')->where('nota_id', $id)->delete();

            // 2. delete massal permanent (softdeletes) tidak pakai model
            $data_lama = DB::table($px.'data_jual')->where('nota_id', $id)->whereNotNull('deleted_at')->delete();
            $data_lama = DB::table($px.'data_jual')->where('nota_id', $id)->update(['deleted_at'=> $today]);

            for ($x = 0; $x < count($arr_kode); $x++) {
                $hrg_j = (double)implode(preg_split('[,]', $arr_harga[$x]));
                $hrg_b = (double)implode(preg_split('[,]', $arr_modal[$x]));
                $disc = (double)implode(preg_split('[,]', $arr_disc[$x]));

                $data_jual = DB::table($px.'data_jual')->insert(
                    [
                        'nota_id' => $id,
                        'no_nota' => $no_nota,
                        'code' => $arr_kode[$x],
                        'qty' => $arr_qty[$x],
                        'satuan' => $arr_sat[$x],
                        'disc' => $disc,
                        'harga_jual' => $hrg_j,
                        'harga_beli' => $hrg_b
                    ]
                );
            }

            if($data_jual) {
                array_push($isi_pesan, "Semua Data Sukses di-Simpan");
                $info = [
                    'pesan' => 'success',
                    'isi_pesan' => $isi_pesan,
                ];
            } else {
                array_push($isi_pesan, "Rincian Nota Gagal di-Update");
                $info = [
                    'pesan' => 'error',
                    'isi_pesan' => $isi_pesan,
                ];
            }
        } else {
            array_push($isi_pesan, "Tidak ada Perubahan Data");
            $info = [
                'pesan' => 'info',
                'isi_pesan' => $isi_pesan,
            ];
        }

        // get all rincian
        // Cetak Struk
        // 1-Data Usaha
        // 2-Nota dan Rincian
        $usaha = Usaha::where('id', Auth::user()->usaha_id)->with(['kota'])->first();

        $nota_jual = DB::table($px.'nota_jual')
            ->where($px.'nota_jual.id', $id)
            ->leftJoin('users as cust',$px.'nota_jual.customer_id','=','cust.id')
            ->leftJoin('cities','cust.cities_id','=','cities.id')
            ->select($px.'nota_jual.*','cust.name as cust_name','cities.name as kota')
            ->first();

        $data_jual = DB::table($px.'data_jual')
            ->where($px.'data_jual.nota_id', $id)
            ->whereNull($px.'data_jual.deleted_at')
            ->leftJoin($px.'products as prod', $px.'data_jual.code','=','prod.code')
            ->select($px.'data_jual.*', 'prod.name as nama_barang')
            ->get();

        return response()->json([
            'info' => $info,
            'nota' => $nota_jual,
            'data' => $data_jual,
            'usaha' => $usaha,
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
        $today = \Carbon\Carbon::now()->locale('id'); //blm sesuai dgn waktu komputer

        $px = strtolower(Auth::user()->access_key);
        $nota_jual = $px.'_'.'nota_jual';
        $data_jual = $px.'_'.'data_jual';
        $piutang   = $px.'_'.'piutangs';

        DB::table($nota_jual)->where('id', $id)->whereNull('deleted_at')->update(['deleted_at'=> $today]); //::destroy($id);
        DB::table($data_jual)->where('nota_id', $id)->whereNull('deleted_at')->update(['deleted_at'=> $today]); // delete massal sementara
        DB::table($piutang)->where('nota_id', $id)->whereNull('deleted_at')->update(['deleted_at'=> $today]); // delete massal sementara
        return response()->json(
            [
                'pesan' => "success",
                'isi_pesan' => 'Data Nota berhasil di-Hapus'
            ]
        );
    }

    /**
     * buat nota baru
     * Request Nomor Transaksi
     * Nota Penjualan Terakhir
     * format nomor : shift+kassa+tgl+bln+thn+001(nourut) -- P1-010121-001
     * format sesijual : shift+kassa+tgl+bln+thn
     * ex : P1-010121-001 {13}
     * Dasar : Nota Jual atau SesiJual
     */
    public function getNoTrx(Request $request)
    {
        // return $request;
        $table = strtolower(Auth::user()->access_key).'_'.'nota_jual';
        // $table = 'nota_jual';

        // cek nota terakhir
        $nota_jual = DB::table($table)
            ->orderBy('no_nota', 'desc')
            ->where('no_nota', 'like', '%' . $request->kode_sesi . '%')
            // ->whereNull('deleted_at')
            ->first();

        if ($nota_jual != null){
            $nomor = ((int)substr($nota_jual->no_nota,11,3))+1;
            $no_nota = $request->kode_sesi . '-' . sprintf("%03s", $nomor);
        } else {
            $no_nota = $request->kode_sesi . '-001';
            $nomor = 1;
        }
        return response()->json([
            'no_trx'=>$no_nota,
            'data' => $nota_jual
        ]);
    }

    /** load Nota Jual ajax */
    public function loadNotaJual(Request $request){

        // return $request;
        // return $id;
        $table = strtolower(Auth::user()->access_key).'_'.'nota_jual';
        // $table = 'nota_jual';

        $nota_jual = DB::table($table)
            ->orderBy('no_nota','asc')
            ->where('no_nota', 'like', $request->kode_sesi . '%')
            ->leftJoin('users as cust', $table.'.customer_id','=','cust.id')
            ->leftJoin('users as user', $table.'.user_id','=','user.id')
            ->select($table.'.*','user.name as nama_user','cust.name as nama_customer');

        if ($request->isShow === "true") {
            // tampilkan data yang dihapus = "tampilkan hapus";
            $nota_jual = $nota_jual->get();
        } else {
            // lewati data yang dihapus "jangan tampilkan hapus";
            $nota_jual = $nota_jual->whereNull($table.'.deleted_at')->get();
        }

        return Response()->json(['data' => $nota_jual]);
    }

    /** load-data-nota --load Data Jual ajax */
    public function loadDataJual($id){

        $px = Auth::user()->access_key.'_';

        $data_jual = DB::table($px.'data_jual')
            // ->orderBy('nota_id','asc')
            ->where("nota_id", $id)
            ->whereNull($px.'data_jual.deleted_at')
            ->leftJoin($px.'products as prod', $px.'data_jual.code','=','prod.code')
            ->leftJoin($px.'satuans as satuan', 'prod.sat_konversi','=','satuan.tipe')
            ->select($px.'data_jual.*',
                'prod.name as nama_barang',
                'prod.sat_konversi as konversi',
                'prod.nil_konversi as nilai_konv',
                'prod.sat_jual as sat_dasar',
                'prod.harga_jual as harga_dasar',
                'prod.harga_modal as harga_modal',
                'prod.berat as berat',
                'satuan.kode as kode_konv'
            )->get(); //array

        $nota_jual = DB::table($px.'nota_jual')->orderBy('id','asc')
            ->where("id",$id)
            ->first(); //not array

        return Response()->json([
            'data' => $data_jual,
            'nota' => $nota_jual,
        ]);
    }

    public function loadDataCustomer() {
        $px = Auth::user()->access_key.'_';
        $piutang = DB::table($px.'piutangs')
            ->select('customer_id', DB::raw('SUM(jumlah) as total'))
            ->groupBy('customer_id');

        $customer = User::orderBy('name','asc')
            // ->with(['kota'])
            ->where('relations_id', Auth::user()->usaha_id)
            ->where('active', 1)
            ->leftJoin('cities','users.cities_id','=','cities.id')
            ->leftJoinSub($piutang, 'piutang', function($join) {
                $join->on('users.id', '=', 'piutang.customer_id');
            })
            ->select('users.*','cities.name as kota', 'piutang.*')
            ->get();

        return Response()->json($customer);
    }

    /** load data ajax */
    public function loadDataBarang(){

        $px = Auth::user()->access_key.'_';

        $product = DB::table($px.'products')->orderBy('code','asc')
            ->whereNull($px.'products.deleted_at')
            ->leftJoin($px.'satuans as sat', $px.'products.sat_konversi','=','sat.tipe')
            ->leftJoin($px.'categories as kate', $px.'products.kategory_id','=','kate.id')
            ->select(
                $px.'products.*',
                'kate.name as kategori',
                'sat.nilai as nilai_konv',
                'sat.kode as kode_konv')
            ->get();

        return Response()->json(['data' => $product]);
    }

    // public function caribarang($code){
    //     $px = Auth::user()->access_key.'_';
    //     $product = DB::table($px.'products')
    //         ->orderBy('code','asc')
    //         ->where('code',$code)
    //         ->leftJoin($px.'satuans as konv', $px.'products.sat_konversi','=','konv.tipe')
    //         ->leftJoin($px.'categories as kate', $px.'products.kategory_id','=','kate.id')
    //         ->select($px.'products.*','kate.name as kategori','konv.nilai as nilai_konv','konv.kode as kode_konv')
    //         ->first();

    //     return Response()->json(['data' => $product]);
    // }
}

