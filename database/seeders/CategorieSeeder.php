<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert("INSERT INTO `categories` (`id`, `name`, `icons`, `active`, `deleted_at`, `created_at`, `updated_at`) VALUES
        (1, 'Kerupuk Merah', NULL, 1, NULL, '2021-07-17 00:42:57', '2021-07-17 00:42:57'),
        (2, 'Rubik', NULL, 1, NULL, '2021-07-17 00:43:01', '2021-07-17 00:43:01'),
        (3, 'Tepung', NULL, 1, NULL, '2021-07-17 00:43:12', '2021-07-17 00:43:12'),
        (4, 'K. Bungkus', NULL, 1, NULL, '2021-07-17 00:43:19', '2021-07-17 00:43:19'),
        (5, 'K. Timbang', NULL, 1, NULL, '2021-07-17 00:43:28', '2021-07-17 00:43:28'),
        (6, 'Bulan', NULL, 1, NULL, '2021-07-17 00:43:34', '2021-07-17 00:43:34'),
        (7, 'Sakura', NULL, 1, NULL, '2021-07-17 00:43:39', '2021-07-17 00:43:39'),
        (8, 'Halaban', NULL, 1, NULL, '2021-07-17 00:43:57', '2021-07-17 00:43:57'),
        (9, 'JB', NULL, 1, NULL, '2021-07-17 00:44:02', '2021-07-17 00:44:02'),
        (10, 'BB', NULL, 1, NULL, '2021-07-17 00:44:08', '2021-07-17 00:44:08'),
        (11, 'PT', NULL, 1, NULL, '2021-07-17 00:44:11', '2021-07-17 00:44:11'),
        (12, 'Tim Jawa', NULL, 1, NULL, '2021-07-17 00:44:18', '2021-07-17 00:44:18'),
        (13, 'Kerang / Stick', NULL, 1, NULL, '2021-07-17 00:44:26', '2021-07-17 00:44:26'),
        (14, 'Toples', NULL, 1, NULL, '2021-07-17 00:44:44', '2021-07-17 00:44:44'),
        (15, 'Kue Kering', NULL, 1, NULL, '2021-07-17 00:44:50', '2021-07-17 00:44:50'),
        (16, 'Bedeng', NULL, 1, NULL, '2021-07-17 00:44:55', '2021-07-25 21:05:12');
        ");
    }
}
