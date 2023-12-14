<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            // 'name' => Str::random(10),
            // 'email' => Str::random(10).'@gmail.com',
            // 'password' => Hash::make('password'),

            'name'      => 'Toni Rizal',
            'username'  => 'toni.rizal',
            'email'     => 'tonirizal77@gmail.com',
            'password'  => Hash::make('admin'),
            'alamat'    => 'Komp. Ruko Barcelona Blok J No. 9 Kel. Belian Kec. Batam Kota',
            'cities_id' => 48,
            'prov_id'   => 32,
            'telpon'    => '+62 812-6670-0175',
            'usaha_id'  => '1',
            'role_id'   => '1',
            'active'    => true,
            'access_key' => 'sidimoscom',
            'remember_token' => Str::random(10),
            'email_verified_at' => \Carbon\Carbon::now(),
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
    }
}
