<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id = [1,2,3,4,5,6,7,8,9,10,11,12];
        $name = [
            'Batam Kota','Batu Aji', 'Batu Ampar','Belakang Padang',
            'Bengkong','Bulang','Galang','Lubuk Baja','Nongsa',
            'Sagulung','Sei Beduk','Sekupang'
        ];

        $gabung = array_combine($id, $name);

        foreach($gabung as $id => $name) {
            DB::table('kecamatans')->insert(
                [
                'id' => $id,
                'name' => $name,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                ],
            );
        }
    }
}
