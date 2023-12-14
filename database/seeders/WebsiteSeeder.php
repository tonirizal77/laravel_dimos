<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('websites')->insert([
            'nama'       => 'SiDiMoS.com',
            'email'      => 'support@sidimos.com',
            'alamat'     => 'Komp. Ruko Barcelona Blok J No. 9 Kel. Belian Kec. Batam Kota',
            'telp'       => '+62 812-6670-0175',
            'kota'       => 'Batam',
            'Provinsi'   => 'Kepulauan RIau',
            'urlWebsite' => 'https://www.sidimos.com',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
