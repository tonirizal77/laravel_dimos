<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// use App\Helpers\ResponseFormatter;

use App\Models\Supplier;
use App\Models\Province;
use App\Models\Kota;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinsi = Province::orderBy('name', 'asc')->get();

        return view('ui_admin.pages.master-data.supplier_list',
            ['provinsi' => $provinsi]
        );
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
        $px = Auth::user()->access_key . "_suppliers";

        // return $request;
        #cara 1
        $id = Supplier::from($px)->insertGetId([
            'nama'       => strtoupper($request->nama),
            'alamat'     => $request->alamat,
            'telpon'     => ($request->telpon == null) ? "-" : $request->telpon,
            'kota_id'    => $request->kota,
            'prov_id'    => $request->provinsi,
            'status'     => $request->status,
        ]);

        $supplier = Supplier::from($px)->where('id', $id)
            ->with(['kota','provinsi'])
            ->first();

        if($id) {
            // With Ajax
            return response()->json([
                'info' => [
                    'status' => 'success',
                    'pesan' => 'Data Supplier Berhasil di-Tambahkan',
                ],
                'data' => $supplier,
            ]);
        } else {
            return response()->json([
                'info' => [
                    'status' => 'error',
                    'pesan' => 'Data Supplier Gagal di-Tambahkan',
                ],
                'data' => null,
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $px = Auth::user()->access_key."_";
        $supplier = DB::table($px.'suppliers')->orderBy('id', 'asc')
        ->where('id', $id)
        ->first();

        return response()->json(['data'=>$supplier]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $px = Auth::user()->access_key . "_suppliers";

        $update = Supplier::from($px)->where('id', $id)
            ->update([
                'nama'       => strtoupper($request->nama),
                'alamat'     => $request->alamat,
                'telpon'     => ($request->telpon == null) ? "-" : $request->telpon,
                'kota_id'    => $request->kota,
                'prov_id'    => $request->provinsi,
                'status'     => $request->status,
            ]);

        if($update) {
            // With Ajax
            $supplier = Supplier::from($px)->where('id', $id)
                ->with(['kota','provinsi'])->first();

            return response()->json([
                'info' => [
                    'status' => 'success',
                    'pesan' => 'Data Supplier Berhasil di-update',
                ],
                'data' => $supplier,
            ]);
        } else {
            return response()->json([
                'info' => [
                    'status' => 'error',
                    'pesan' => 'Data Supplier Gagal di-update',
                ],
                'data' => null,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $table = Auth::user()->access_key . "_suppliers";
        $supplier = Supplier::from($table)->where('id',$id)
            // ->delete();
            ->update(['deleted_at' => \Carbon\Carbon::now()]);

        return response()->json([
            'pesan' => 'Data Supplier berhasil di-Hapus',
        ]);
    }

    /** load data ajax */
    public function loadDataAjax(){
        $table = Auth::user()->access_key . "_suppliers";
        $supplier = Supplier::from($table)->orderBy('nama','asc')
            ->whereNull('deleted_at')
            ->with(['kota','provinsi'])
            ->get();

        return Response()->json([
            'data'  => [
                'supplier' => $supplier,
            ],
            'info' => [
                'status' => 'success',
                'message' => null,
            ],
        ]);
    }
}
