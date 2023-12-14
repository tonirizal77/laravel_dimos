<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $id_camat = [1,2,3,4,5,6,7,8,9,10,11,12];

        $kecamatan = [
            'Batam Kota','Batu Aji', 'Batu Ampar','Belakang Padang',
            'Bengkong','Bulang','Galang','Lubuk Baja','Nongsa',
            'Sagulung','Sei Beduk','Sekupang'
        ];

        $lurah = [
            ['Baloi Permai','Belian','Sukajadi','Sungai Panas','Taman Baloi','Teluk Tering'],
            ['Bukit Tempayan','Buliang','Kibing','Tanjung Uncang'],
            ['Batu Merah','Kampung Seraya','Sungai Jodoh','Tanjung Sengkuang'],
            ['Kasu','Pecong','Pemping','Pulau Terong','Sekanak Raya','Tanjung Sari'],
            ['Bengkong Indah','Bengkong Laut','Sadai','Tanjung Buntung'],
            ['Batu Legong','Bulang Lintang','Pantai Gelam','Pulau Buluh','Setokok','Temoyong'],
            ['Air Raja','Galang Baru','Karas','Pulau Abang','Rempang Cate','Sembulang','Sijantung','Subang Mas'],
            ['Baloi Indah','Batu Selicin','Kampung Pelita','Lubuk Baja Kota','Tanjung Uma'],
            ['Batu Besar',"Kabil",'Ngenang','Sambau'],
            ['Sagulung Kota','Sungai Binti','Sungai Langkai','Sungai Lekop','Sungai Pelunggut','Tembesi'],
            ['Duriangkang','Mangsang','Muka Kuning','Tanjung Piayu'],
            ['Patam Lestari','Sungai Harapan','Tanjung Pinggir','Tanjung Riau','Tiban Baru','Tiban Indah','Tiban Lama'],
        ];

        $gabung = array_combine($id_camat, $lurah);

        $urut = 1;
        foreach($gabung as $id => $name) {
            foreach($name as $value) {
                DB::table('kelurahans')->insert([
                    'camat_id' => $id,
                    'name' => $value,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);

                DB::table('wilayahs')->insert([
                    'camat_id' => $id,
                    'lurah_id' => $urut,
                    'name' => $value,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);

                $urut++;
            }
        }

    }
}
