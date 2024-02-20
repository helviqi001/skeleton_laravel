<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\MenuItem;
use App\Models\Privilege;

class PriviledgeSeeder extends Seeder
{
    public function run()
    {
        if(Privilege::all()->count() == 0) {
            $roles = Role::all();
            foreach ($roles as $role) {
                $rows = MenuItem::all();
                $menus = [];
                foreach ($rows as $menu) {
                    if ($role->id == 1) {
                        $menus[] = [
                            'role_id' => $role->id,
                            'menu_item_id' => $menu->id,
                            'view' => 1,
                            'add' => 1,
                            'edit' => 1,
                            'delete' => 1,
                            'other' => 1,
                        ];
                    } else {
                        $menus[] = [
                            'role_id' => $role->id,
                            'menu_item_id' => $menu->id,
                            'view' => 0,
                            'add' => 0,
                            'edit' => 0,
                            'delete' => 0,
                            'other' => 0,
                        ];
                    }
                }
                Privilege::insert($menus);
            }
        }
    }
}
