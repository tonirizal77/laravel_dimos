<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CitiesController extends Controller
{
    public function loadKota(Request $req){
        $kota = DB::table('cities')->orderBy('name', 'asc')
            ->where('cities.province_id','=', $req->id)
            ->get();
        return Response()->json(['kota' => $kota]);
    }

    public function loadProvinsi(){
        $provinsi = DB::table('provinces')->orderBy('name', 'asc')->get();
        return Response()->json(['provinsi' => $provinsi]);
    }
}
