<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Superadmin',
                'email' => 'superadmin@mailinator.com',
                'username' => 'superadmin',
                'avatar' => null,
                'email_verified_at' => now(),
                'birth_date' => now()->format('Y-m-d'),
                'password' => Hash::make('123123'),
                'role_id' => Role::whereName('Superadmin')->first()->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@mailinator.com',
                'username' => 'admin',
                'avatar' => null,
                'email_verified_at' => now(),
                'birth_date' => now()->format('Y-m-d'),
                'password' => Hash::make('123123'),
                'role_id' => Role::whereName('Admin')->first()->id,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        User::insert($data);
    }
}
