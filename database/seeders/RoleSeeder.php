<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Superadmin',
                'description' => 'All CRUD',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Admin',
                'description' => 'Assigned by Superadmin',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        Role::insert($data);
    }
}
