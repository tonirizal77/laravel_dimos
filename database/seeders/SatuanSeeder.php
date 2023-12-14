<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $satuanB = ['BALL','CTN','DUS','KRG'];
        $satuanS = ['BOX','TIM','KRAT','KTK', 'IKAT','JRGN','PACK','PAIRS','PAIL','RTG','SLOP'];
        $satuanK = ['PCS','BKS','BLEK','LBR','KG','KLG'];

        //id, tipe, konversi, nilai, kode

        // $table = 'yszumrlz1n_satuans';
        $table = 'satuans';

        foreach ($satuanB as $tipe) {
            DB::table($table)->insert([
                'tipe' => $tipe,
                'konversi' => "0",
                'nilai' => "1",
                'kode' => "B",
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
        foreach ($satuanS as $tipe) {
            DB::table($table)->insert([
                'tipe' => $tipe,
                'konversi' => "0",
                'nilai' => "1",
                'kode' => "S",
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
        foreach ($satuanK as $tipe) {
            DB::table($table)->insert([
                'tipe' => $tipe,
                'konversi' => "0",
                'nilai' => "1",
                'kode' => "K",
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

        $tipe = [
            'CTN.BOX.PCS',
            'CTN.PACK.PCS',
            'CTN.PAIRS.PCS',
            'CTN.BOX',
            'BOX.PCS',
            'CTN.PCS',
            'BALL.TIM.KG',
            'KRG.TIM.KG',
            'BALL.KG',
        ];
        $nilai = [
            ['100.50.1','B.S.K'],
            ['100.10.1','B.S.K'],
            ['50.2.1','B.S.K'],
            ['100.50','B.S'],
            ['50.1','S.K'],
            ['25.1','B.K'],
            ['10.5.1','B.S.K'],
            ['25.5.1','B.S.K'],
            ['5.1','B.K'],
        ];

        // $gabung = array_combine($tipe, $nilai);
        // foreach($gabung as $tipe => $nilai) {
        //     DB::table($table)->insert([
        //         'tipe' => $tipe,
        //         'konversi' => "1",
        //         'nilai' => $nilai[0],
        //         'kode' => $nilai[1],
        //         'created_at' => \Carbon\Carbon::now(),
        //         'updated_at' => \Carbon\Carbon::now(),
        //     ]);
        // }
    }
}
