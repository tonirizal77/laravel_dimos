<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Website;
use App\Models\Paket;

class FrontendController extends Controller
{
    public function index()
    {
        $website = Website::orderBy('id','asc')->first();
        $paket = Paket::all();

        if ($website == null) {
            $website = Website::create([
                "nama"       => "SiDimos.com",
                "email"      => "support@dimos.com",
                "alamat"     => "Jl. Hangtuah No. 9 Kel. Belian Kec. Batam Kota",
                "telp"       => "+62 822-8890-5802",
                "kota"       => "Batam",
                "provinsi"   => "Kepulauan Riau",
                "urlWebsite" => "https://sidimos.com",
            ]);

            $website = json_encode($website);

        };

        $data = [
            'website'=>$website,
            'paket' => $paket,
        ];

        if (Auth::check()) {
            // Jangan dihapus
            // jika user sudah login
            // Controller Marketplace
            // return "Home Product Supplier Bersangkutan";
        }
        return view('ui_flexstart.index', $data);
        // return view('ui_tempo.index', $data);
    }
}
