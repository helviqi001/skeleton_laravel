<?php

namespace App\Http\Controllers\CMS;

use App\Services\Gateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use \Yajra\DataTables\DataTables;
use App\Models\MenuGroup;
use App\Models\MenuItem;
use App\Models\Role;
use App\Models\Privilege;

class MenuItemController extends Controller
{
    public function index()
    {
        return view('pages.Configuration.MenuItem.index');
    }

    public function create()
    {
        $menuGroups = MenuGroup::get()->toArray();
        return view('pages.Configuration.MenuItem.create', compact('menuGroups'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // insert new menu item
        $create = MenuItem::create($data);
        if ($create) {
            // create privilege of new menu item for all role
            $roles = Role::all();
            if ($roles) {
                foreach ($roles as $keyX => $role) {
                    // set param and default value to insert privilege
                    $privilege['role_id'] = $role->role_id;
                    $privilege['menu_item_id'] = $create->menu_item_id;
                    $privilege['view'] = 0;
                    $privilege['add'] = 0;
                    $privilege['edit'] = 0;
                    $privilege['delete'] = 0;
                    $privilege['other'] = 0;
                    // insert privilege
                    Privilege::create($privilege);
                }
            }
            return redirect('menu-item')->with('success', 'Menu Item Created');
        }
        return back()->with('error', 'Oops, something went wrong!');
    }

    public function edit($id)
    {
        $data = MenuItem::where('menu_item_id', $id)->first();
        $menuGroups = MenuGroup::get()->toArray();

        return view('pages.Configuration.MenuItem.edit', compact('data', 'menuGroups'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');

        // insert new role
        $update = MenuItem::where('menu_item_id', $id)->update($data);
        if ($update) {
            return redirect('menu-item')->with('success', 'Menu Item Updated');
        }
        return back()->with('error', 'Oops, something went wrong!');
    }

    public function delete($id)
    {
        MenuItem::where('menu_item_id', $id)->delete();
        return redirect('menu-item')->with('success', 'Menu Item Deleted');
    }

    public function fnGetData(Request $request)
    {
        // set page parameter for pagination
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data  = new MenuItem();
        $data = $data->with('menu_group');

        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $data = $data->where('name', 'LIKE', '%'.$request->keyword.'%');
        }

        //Setting Limit
        $limit = 10;
        if (!empty($request->input('length'))) {
            $limit = $request->input('length');
        }

        $data = $data->orderBy($request->columns[$request->order[0]['column']]['name'], $request->order[0]['dir'])->paginate($limit);


        $data = json_encode($data);
        $data = json_Decode($data);

        return DataTables::of($data->data)
            ->skipPaging()
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->addColumn('action', function ($data) {
                $btn = '<a class="btn btn-default" href="menu-item/' . $data->menu_item_id . '">Edit</a>';
                $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;" onclick="fnDelete(this,' . $data->menu_item_id . ')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}


