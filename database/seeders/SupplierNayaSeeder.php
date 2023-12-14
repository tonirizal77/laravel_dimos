<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierNayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `yszumrlz1n_suppliers` (`nama`, `alamat`, `kota_id`, `prov_id`, `telpon`) VALUES
        ('AYONG','BUKIT TINGGI',93,32,'08116614615'),
        ('PT. INCASI RAYA','Jl. Bypass - Padang',318,32,'08126702205'),
        ('SORMIN','PADANG',318,32,'081363464377'),
        ('PT. SAMUDRA DISTRA PRIMA','Jl. Veteran No. 210',93,32,'0752-33045'),
        ('RINZANO','BATU SANGKAR',318,32,''),
        ('SUMBER','PARIK',345,32,'085358092739'),
        ('ADEK','TARATAK',345,32,'081374330343'),
        ('TEH COCO','PADANG',318,32,''),
        ('MCL','BUKIT TINGGI',93,32,''),
        ('PANCA PILAR TANGGUH','BUKUT TINGGI',93,32,'075291424'),
        ('DEDY TARAM','TARAM',345,32,''),
        ('UD ANA JAYA','PEKAN BARU',350,26,'085271684488'),
        ('COCA COLA','TALAWI',345,32,''),
        ('AWS','TANJUNG PATI',345,32,''),
        ('JAYA MURNI','BUKIT TINGGI',93,32,''),
        ('INDOMARCO','PAYAKUMBUH',345,32,''),
        ('ABADI','PDG PANJANG',321,32,''),
        ('DIKI BKT','BUKIT TINGGI',93,32,'082382323570'),
        ('BW','PADANG',318,32,'082385672140'),
        ('ASRI','PADANG DATAR',345,32,''),
        ('TOKO RATU','PILADANG',345,32,''),
        ('CV  TERATAI KRISTAL/ SOSRO','PASAR ATAS BUKIT TINGGI',93,32,''),
        ('UD OYON','PEKAN BARU',350,26,''),
        ('OPET','PAYOLANSEK',345,32,''),
        ('JAYA SUBUR','PAYAKUMBUH',345,32,''),
        ('SABUN TOMBAK','PADANG',318,32,''),
        ('TARI KCP UDANG','PADANG',318,32,''),
        ('BUDI','SIMP.KOMPI C TJ.PATI',345,32,''),
        ('METRACO','BUKIT TINGGI',93,32,''),
        ('PT AJINOMOTO','PAYAKUMBUH',345,32,''),
        ('PURNAMA JAYA / LUWAK','BUKIT TINGGI',93,32,''),
        ('SMB','PAYAKUMBUH',345,32,''),
        ('SINAR MUTIARA','PAYAKUMBUH',345,32,''),
        ('ARMEN','TJ AMPALU',394,32,''),
        ('VIKTORIA','PD PANJANG',321,32,''),
        ('PT SINAR MITRA USAHA','PADANG',318,32,''),
        ('PT PSM/M 150','PADANG',318,32,''),
        ('FKS / KEDELE','MEDAN',278,34,''),
        ('LAWEH','PAYAKUMBUH',345,32,''),
        ('PT SMS / UHT','BUKIT TINGGI',93,32,''),
        ('UD LEPAS','BUKIT TINGGI',93,32,''),
        ('BENDERA','BUKIT TINGGI',93,32,''),
        ('CV TERATAI KRISTAL / SOSRO','BASO',93,32,''),
        ('ING','LIMBANANG',345,32,''),
        ('PT EVERBRIGHT / ABC','PADANG',318,32,''),
        ('PT HNK / SASA','PADANG',318,32,''),
        ('UNILEVER / FEBI','BTS',345,32,''),
        ('ALAM JAYA WIRASENTOSA','PADANG',318,32,''),
        ('PT AWS / AQUA','BUKIT TINGGI',93,32,''),
        ('CV NAYRA / MITRA','PAYAKUMBUH',345,32,''),
        ('PT.PANCA PILAR TANGGUH','BUKIT TINGGI',93,32,''),
        ('PT GARUDA','TJ PATI',345,32,''),
        ('PT PMA / NABATI','PAYAKUMBUH',345,32,''),
        ('RAHMAT YUDI','PILADANG',345,32,''),
        ('ST RAJO AMEH','BUKIT TINGGI',93,32,'');
        ");
    }
}
