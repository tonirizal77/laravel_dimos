<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieNayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `7ayzx1jnm3_categories` (`id`, `name`) VALUES
        ('1','JAGUNG'),
        ('10','ABC & BUMBU'),
        ('11','AGAR AGAR'),
        ('12','AIR MINERAL'),
        ('13','AJINOMOTO'),
        ('14','ASHOI'),
        ('15','BENDERA SUSU'),
        ('16','BERAS'),
        ('17','BISCUIT'),
        ('18','BLAU'),
        ('19','CUKA'),
        ('20','EMPING'),
        ('21','GARAM'),
        ('22','GAS'),
        ('23','GELAS'),
        ('24','GULA'),
        ('25','INDOMIE'),
        ('26','KACANG'),
        ('27','KECAP'),
        ('28','KERTAS'),
        ('29','KERUPUK'),
        ('30','KOPI'),
        ('31','KOREK'),
        ('32','KUACI'),
        ('33','KUE'),
        ('34','LASA'),
        ('35','MARGARIN'),
        ('36','MASAKO'),
        ('37','MENTEGA'),
        ('38','MIE'),
        ('39','MINUMAN'),
        ('40','MINYAK'),
        ('41','MISES'),
        ('42','OBAT NYAMUK'),
        ('43','PEPSODENT'),
        ('44','PIPET'),
        ('45','PULUT'),
        ('46','ROKOK'),
        ('47','ROTI'),
        ('48','ROYCO'),
        ('49','SABUN'),
        ('5','SOSIS'),
        ('50','SAJIKU'),
        ('51','SAMBAL'),
        ('52','SARDEN'),
        ('53','SARI MANIS'),
        ('54','SASA'),
        ('55','SEBET'),
        ('56','SIRUP'),
        ('57','SUSU'),
        ('58','TBM'),
        ('59','TEH'),
        ('60','TEPUNG'),
        ('61','UNILEVER'),
        ('62','WINGS'),
        ('65','LIDI'),
        ('66','PERMEN'),
        ('67','MAKANAN'),
        ('69','BAHAN KUE'),
        ('99','ONGKOS');
        ");
    }
}
