<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create user dummy 10 data
        // \App\Models\User::factory(5)->create();

        $this->call([
            UsahaSeeder::class,
            RoleSeeder::class,
            CityTableSeeder::class,
            ProvinceTableSeeder::class,
            PaketSeeder::class,
            WebsiteSeeder::class,
            // SatuanSeeder::class,
            // ProductSeeder::class,
            // UserSeeder::class,
            // CategorieSeeder::class,
            // SupplierSeeder::class,
            // DistrictTableSeeder::class,
            // KelurahanSeeder::class,
            // KecamatanSeeder::class,
        ]);
    }
}
