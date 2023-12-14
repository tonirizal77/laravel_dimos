<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paket = [
            [
                "Free", "Paket-Gratis.png", 14, 0, 0,
                "Paket ini bersifat uji coba tanpa biaya apapun.",
                "100,3,500", "Cocok untuk yang baru mencoba memulai usaha kecil.",
                "card-warning", "bg-gradient-warning", 0
            ],
            [
                "Standar", "Paket-Standar.png",365, 0, 150000,
                "-",
                "500,3,1000", "Cocok untuk usaha Toko Kecil",
                "card-primary", "bg-gradient-primary", 0
            ],
            [
                "Premium", "Paket-Premium.png", 365, 0, 200000,
                "-",
                "1000,5,3000", "Cocok untuk usaha Toko Menengah dengan pelanggan yang cukup banyak.",
                "card-gray-dark", "bg-gradient-gray-dark", 0
            ],
            [
                "Platinum", "Paket-Platinum.png", 365, 0, 300000,
                "-",
                "2000,10,5000", "Cocok untuk usaha Toko Besar/Grosir dengan pelanggan yang banyak.",
                "card-danger", "bg-gradient-danger", 0
            ],
            [
                "Unlimited", "Paket-Unlimited.png", 365, 0, 500000,
                "-",
                "Tanpa Batas,Tanpa Batas,Tanpa Batas", "Cocok untuk Usaha Toko Besar/Distributor yang mengisi pelanggan toko.",
                "card-info", "bg-gradient-info", 0
            ],
        ];

        foreach($paket as $p) {
            DB::table("pakets")->insert([
                'name' => $p[0],
                'gambar' => $p[1],
                'duration' => $p[2],
                'disc' => $p[3],
                'biaya' => $p[4],
                'uraian' => $p[5],
                'max_features' => $p[6],
                'keterangan' => $p[7],
                'warna_header' => $p[8],
                'warna_body' => $p[9],
                'lama_disc' => $p[10],
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
