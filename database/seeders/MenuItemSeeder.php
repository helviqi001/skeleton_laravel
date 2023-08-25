<?php

namespace Database\Seeders;

use App\Models\MenuGroup;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Manage Admin',
                'url' => '/admin',
                'menu_group_id' => MenuGroup::where('name' , '=', 'Admin')->first()->menu_group_id,
                'sequence' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Manage Role',
                'url' => '/role',
                'menu_group_id' => MenuGroup::where('name' , '=', 'Admin')->first()->menu_group_id,
                'sequence' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Manage Menu Group',
                'url' => '/menu-group',
                'menu_group_id' => MenuGroup::where('name' , '=', 'Configuration')->first()->menu_group_id,
                'sequence' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Manage Menu Item',
                'url' => '/menu-item',
                'menu_group_id' => MenuGroup::where('name' , '=', 'Configuration')->first()->menu_group_id,
                'sequence' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        MenuItem::insert($data);
    }
}
