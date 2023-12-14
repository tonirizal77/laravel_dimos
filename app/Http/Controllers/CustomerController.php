<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Usaha;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinsi = DB::table('provinces')->orderBy('name', 'asc')->get();
        return view('ui_admin.pages.master-data.customer_list',
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
        //
        $relations = Usaha::where('id', Auth::user()->usaha_id)->first();

        // if (Auth::user()->tipe == 1) {
        //     $tipe = 2; //Store
        // } else if (Auth::user()->tipe == 2) {
        //     $tipe = 3; //Customer
        // }

        $customer = new User;
        $customer->name = trim($request->nama_customer);
        $customer->email = trim(strtolower($request->email));
        $customer->password = Hash::make('123456');
        $customer->alamat = $request->alamat;
        $customer->telpon = $request->telpon;
        $customer->cities_id = $request->kota;
        $customer->prov_id = $request->provinsi;
        $customer->active = $request->status;
        // $customer->tipe = $tipe;
        $customer->role_id = 1; // admin
        $customer->relations_id = $relations->id;
        $customer->name_relations = $relations->nama;
        $customer->username = "CUST.?";
        $customer->remember_token = Str::random(10);
        $sukses = $customer->save();

        $customer->username = "CUST.".$customer->id;
        $sukses = $customer->save();

        if ($sukses) {
            $info = [
                'pesan' => 'success',
                'isi_pesan' => 'Data Customer Sukses di-Tambahkan',
            ];
        } else {
            $info = [
                'pesan' => 'error',
                'isi_pesan' => 'Data Customer Gagal di-Tambahkan',
            ];
        }

        return response()->json([
            'info' => $info,
            'data' => $customer,
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
        // return $id;
        // $user = User::where('id', $id)->first();
        $user = DB::table('users')->orderBy('id', 'asc')
            ->where('users.id','=', $id)
            ->leftJoin('cities','users.cities_id','=','cities.id')
            ->select('users.*','cities.province_id as prov_id')
            ->first();

        return response()->json($user);
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
        $data = $request->all();
        $customer = User::where('id', $id)->update([
            'name'        => trim($request->nama_customer),
            'username'    => 'CUST.'.$id,
            'email'       => trim(strtolower($request->email)),
            'telpon'      => $request->telpon,
            'password'    => Hash::make($request->password),
            'alamat'      => $request->alamat,
            'cities_id'   => $request->kota,
            'prov_id'     => $request->provinsi,
            'active'      => $request->status,
        ]);

        if ($customer) {
            $info = [
                'pesan' => 'success',
                'isi_pesan' => 'Data Customer Sukses di-Update',
            ];
        } else {
            $info = [
                'pesan' => 'error',
                'isi_pesan' => 'Data Customer Gagal di-Update',
            ];
        }

        $customer = DB::table('users')->where('users.id','=', $id)
            ->leftJoin('cities','users.cities_id','=','cities.id')
            ->select('users.*','cities.name as kota')
            ->first();

        return response()->json([
            'info' => $info,
            'data' => $customer
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
        //
    }

    public function cekDataUser(Request $request) {

        if (str_contains($request, 'username')) {
            $cari = User::where('username', '=', trim($request->username));
        } else if (str_contains($request, 'telpon')) {
            $cari = User::where('telpon', '=', trim($request->telpon));
        } else {
            $cari = User::where('email', '=', trim($request->email));
        }

        $cari = $cari->exists(); // menghasilkan 1 / 0 (true/false)

        if ($cari) {
            return response()->json(false);
            // $info = "nama sudah ada"; // user found
            // $data = Satuan::where('tipe', '=', $request->kode_satuan)->first();
        } else {
            return response()->json(true);
            // $info = "nama belum ada"; // user not found
        }
        // return response()->json(['data'=>$data, 'status'=> $cari ,'message'=>$info]);
    }

    public function loadDataCustomer()
    {
        $customer = DB::table('users')->orderBy('name','asc')
            ->where('relations_id', Auth::user()->usaha_id)
            ->leftJoin('cities','users.cities_id','=','cities.id')
            ->select('users.*','cities.name as kota')
            ->get();

        return Response()->json(['data' => $customer]);
    }
}
