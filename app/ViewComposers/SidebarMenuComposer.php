<?php

namespace App\ViewComposers;

use App\Models\Privilege;
use App\Models\GroupMenu;
use App\Models\Menu;
use Illuminate\View\View;
use Session;
use App\Http\Traits\GatewayTrait;

class SidebarMenuComposer
{
    use GatewayTrait;

    public function __construct()
    {
        //
    }

    public function compose(View $view)
    {
        // GET ADMIN PRIVILEDGE
        $privs = Privilege::where('role_id', Session::get('SESS_USERROLE'))->where('view',1)->get();
        if (count($privs) == 0) {
            $privs = Privilege::where('role_id',Session::get('SESS_USERROLE'))->where('view',1)->get();
        }
        $menu = GroupMenu::orderBy('sequence', 'asc')->with(['menu' => function($q) {
            return $q->orderBy('sequence', 'asc');
        }])->get();
        $data = [];
        $menus = [];
        foreach ($menu as $key => $value) {
            $anyMenu = false;
            foreach ($value['menu'] as $keyX => $item) {
                if ($item['group_menu_id'] == 0) {
                    $data[$key]['menuType'] = 0;
                    $data[$key]['menuName'] = $item['name'];
                    $data[$key]['menuUrl'] = $item['url'];
                }
                $data[$key]['groupMenuName'] = $value['name'];
                $data[$key]['groupMenuIcon'] = '';
                $data[$key]['menuType'] = 1;
                $data[$key]['sequence'] = $value['sequence'];
                $data[$key]['menu'][$keyX]['menuName'] = $item['name'];
                $data[$key]['menu'][$keyX]['menuUrl'] = $item['url'];
                $data[$key]['menu'][$keyX]['menuView'] = 0;
                foreach ($privs as $keyY => $priv) {
                    if ($priv['menu_id'] == $item['menu_id']) {
                        $data[$key]['menu'][$keyX]['menuView'] = 1;
                        $anyMenu = true;
                    }
                }
            }
            if ($anyMenu) {
                $menus[$key] = $data[$key];
            }
        }

        // add if any single menu (group menu without child)
        $singleMenu = Menu::where('group_menu_id', 0)->get();
        foreach ($singleMenu as $key => $value) {
            foreach ($privs as $keyY => $priv) {
                if ($priv['menu_id'] == $value['id']) {
                    $addData['menuName'] = $value['name'];
                    $addData['menuUrl'] = $value['url'];
                    $addData['menuType'] = 0;
                    $addData['sequence'] = $value['sequence'];
                    array_push($menus, $addData);
                }
            }
        }

        // sort by group menu sequence
        usort($menus, function($a, $b) {
            return $a['sequence'] <=> $b['sequence'];
        });
        
        $view->with('sidebarMenus', isset($menus) ? $menus : []);
    }
}
