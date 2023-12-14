<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name' => 'owner','redirect_to' => '/owner',],
            ['name' => 'admin','redirect_to' => '/admin',],
            ['name' => 'user','redirect_to' => '/user',],
            ['name' => 'kasir','redirect_to' => '/kasir',],
            ['name' => 'finance','redirect_to' => '/acc',],
            ['name' => 'staff','redirect_to' => '/staff',],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
