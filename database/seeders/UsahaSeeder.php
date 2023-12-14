<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsahaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usaha')->insert([
            'tipe_usaha' => '0',
            'nama'       => 'SiDiMoS Group',
            'email'      => 'support@sidimos.com',
            'alamat'     => 'Komp. Ruko Barcelona Blok J No. 9 Kel. Belian Kec. Batam Kota',
            'telpon'     => '+62 812-6670-0175',
            'cities_id'  => 48,
            'province_id'=> 17,
            'status'     => true,
            'access_key' => 'sidimoscom',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
