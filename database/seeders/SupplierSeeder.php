<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $supplier = [
            ["Abadi","Padang Panjang","085274520578","Padang Panjang"],
            ["Abdul","Durian Gadang","","Kab 50 Kota"],
            ["Af - Era","Sikasok - Seberang Parit","","Kab 50 Kota"],
            ["Afdal - Anis","Tj.Mungo - Situjuh","085355102517","Kab.50 Kota"],
            ["Agus","Sikasok - Seberang Parit","","Kab 50 Kota"],
            ["Ajuang","Piladang","","Kab 50 Kota"],
            ["Al - Armi","Tj.Mungo - Situjuh","","Kab 50 Kota"],
            ["Bawang Berlian","Surabaya","","Surabaya"],
            ["Bayan","Simp.BR - Piladang","","Kab 50 Kota"],
            ["Ben","Koto Nan Gadang - Tambago","085763189066","Payakumbuh"],
            ["Cici","Padang Karambia","","Payakumbuh"],
            ["Deni","Simpang BR","","Kab 50 Kota"],
            ["Desi - Ujang","Guguak Nunang - Piladang","0852-75122023","Kab 50 Kota"],
            ["Doni","Tj.Mungo","","Kab 50 Kota"],
            ["Edi","Tangah Padang","","Kab 50 Kota"],
            ["Edi p","Guguak Nunang","","Kab 50 Kota"],
            ["El - Amir","Durian Gadang","0813-74888137","Kab 50 Kota"],
            ["Ema","Guguak Nunang","","Kab 50 Kota"],
            ["Ema","Guguak Nunang","","Kab 50 Kota"],
            ["Eni","Tangah Padang","","Kab 50 Kota"],
            ["Eri Nunies","Guguak Nunang - Piladang","0821-71080101","Kab 50 Kota"],
            ["Fauzan","Tangah Padang","","Kab 50 Kota"],
            ["Fifi","Tg.Padang","","Kab 50 Kota"],
            ["Jen","Halaban","","Lareh Sago Halaban"],
            ["Jum","BA 8278 KL      [ Halaban )","","Lareh Sago Halaban"],
            ["Jun","Durian Gadang","","Kab 50 Kota"],
            ["Leni - Kotik","Guguak Bulek","","Kab 50 Kota"],
            ["Lili - Pir","Jorong Piladang","0823-88376696","Kab 50 Kota"],
            ["Linda","Tangah Padang","","Kab 50 Kota"],
            ["Linda - Tuah","Sikasok - Seberang Parit","0823-91518953","Kab 50 Kota"],
            ["Lusi","Guguak Nunang","","Kab 50 Kota"],
            ["Ma 'Un","Sikasok - Seberang Parit","","Kab 50 Kota"],
            ["Mak Nen","Halaban","","Lareh Sago Halaban"],
            ["Mareli","Tj.Mungo - Situjuh","0821-73093199","Kab. 50 Kota"],
            ["Mira","Piladang","","Kab 50 Kota"],
            ["Muan","Piladang","","Kab 50 Kota"],
            ["Mun - Nina","Tj.Mungo - Situjuh","0853-75020606","Kab 50 Kota"],
            ["Nia","Seb.Parit","","Kab 50 Kota"],
            ["Nina - Anto","Sikasok - Seberang Parit","0823-90196946","Kab 50 Kota"],
            ["Nita Gapuak","Sikasok - Seberang Parik","","Kab 50 Kota"],
            ["Pak Nyon","Halaban","","Lareh Sago Halaban"],
            ["Pak Sur","Halaban","","Lareh Sago Halaban"],
            ["Peni","Tj.Mungo - Situjuh","","Kab 50 Kota"],
            ["Peri - Ita","Tj.Mungo - Situjuh","","Kab 50 Kota"],
            ["Pit - Malin","Sungai Cubadak","","Kab 50 Kota"],
            ["Pul","Situjuh","","Kab 50 Kota"],
            ["Ral","Guguak Malintang","","Kab 50 Kota"],
            ["Ramadhan","Suayan","","Kab 50 kota"],
            ["San","Bonai","","Payakumbuh"],
            ["Santi","Piladang","","Kab 50 Kota"],
            ["Santi / Wati","Pakudoan","","Kab 50 Kota"],
            ["Suci - Asnal","Guguak Bulek","","Kab 50 Kota"],
            ["Syaf","Sikasok - Seberang Parit","","Kab 50 Kota"],
            ["Tati","Piladang","","Kab 50 Kota"],
            ["Tek Lis","Sikasok - Seberang Parit","","Kab 50 Kota"],
            ["Tek Yal","Guguak Bulek","","Kab 50 Kota"],
            ["Tika","Tj.Mungo - Situjuh","","Kab 50 Kota"],
            ["Uncu - Lilik","Ibuh","","Payakumbuh"],
            ["Upik","Tg.Padang","","Kab 50 Kota"],
            ["Wati","Palasan - Seb. Parit","","Kab 50 Kota"],
            ["Yanti - Andi","Guguak Bulek","","Kab 50 Kota"],
            ["Yanto","Simp.BR","","Kab 50 Kota"],
            ["Yas","Guguak Nunang","","Kab 50 Kota"],
            ["Yas","Tangah Padang","","Kab 50 Kota"],
            ["Yenti","Tangah Padang","","Kab 50 Kota"],
            ["Zul","Guguak Nunang","","Kab 50 Kota"],
        ];

        foreach ($supplier as $supl) {
            DB::table('suppliers')->insert([
                'nama' => $supl[0],
                'alamat' => $supl[1],
                'telpon' => $supl[2],
                'kota_id' => null,
                'kota' => $supl[3],
                'status' => "1",

                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
