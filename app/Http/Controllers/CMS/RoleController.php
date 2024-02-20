<?php

namespace App\Http\Controllers\CMS;

use App\Services\Gateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use \Yajra\DataTables\DataTables;
use App\Models\Role;
use App\Models\Privilege;
use App\Models\MenuGroup;
use App\Models\MenuItem;

class RoleController extends Controller
{
    public function index()
    {
        return view('pages.Administrator.Role.index');
    }

    public function create()
    {
        $menuItems = MenuItem::with('menu_group')->get()->toArray();

        return view('pages.Administrator.Role.create', compact('menuItems'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // insert new role
        $createRole = Role::create($data);
        if ($createRole) {
            // get all menu for insert privilege later
            $menuItems = MenuItem::get()->toArray();
            foreach ($menuItems as $keyX => $menuItem) {
                // set param and default value to insert privilege
                $privilege['role_id'] = $createRole->id;
                $privilege['menu_item_id'] = $menuItem['menu_item_id'];
                $privilege['view'] = 0;
                $privilege['add'] = 0;
                $privilege['edit'] = 0;
                $privilege['delete'] = 0;
                $privilege['other'] = 0;
                if (array_key_exists('menu', $data)) {
                    foreach ($data['menu'] as $keyY => $menu) {
                        if ($menuItem['id'] == $keyY) {
                            if (array_key_exists('view', $menu)) {
                                $privilege['view'] = 1;
                            }
                            if (array_key_exists('add', $menu)) {
                                $privilege['add'] = 1;
                            }
                            if (array_key_exists('edit', $menu)) {
                                $privilege['edit'] = 1;
                            }
                            if (array_key_exists('delete', $menu)) {
                                $privilege['delete'] = 1;
                            }
                            if (array_key_exists('other', $menu)) {
                                $privilege['other'] = 1;
                            }
                        }
                    }
                }
                // create privilege for new role
                Privilege::create($privilege);
            }
        } else {
            return back()->with('error', 'Oops, something went wrong!');
        }
        return redirect('role')->with('success', 'Role Created');
    }

    public function edit($id)
    {
        $data = Role::where('id', $id)->with('privileges')->first();
        $menuItems = MenuItem::with('menu_group')->get()->toArray();

        return view('pages.Administrator.Role.edit', compact('data', 'menuItems'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        // get role
        $role = Role::where('id', $id)->with('privileges')->first();
        if ($role) {
            foreach ($role->privileges as $keyX => $rolePrivilege) {
                // set param and default value to update privilege
                $privilege['view'] = 0;
                $privilege['add'] = 0;
                $privilege['edit'] = 0;
                $privilege['delete'] = 0;
                $privilege['other'] = 0;
                if (array_key_exists('menu', $data)) {
                    foreach ($data['menu'] as $keyY => $menu) {
                        if ($rolePrivilege['menu_item_id'] == $keyY) {
                            if (array_key_exists('view', $menu)) {
                                $privilege['view'] = 1;
                            }
                            if (array_key_exists('add', $menu)) {
                                $privilege['add'] = 1;
                            }
                            if (array_key_exists('edit', $menu)) {
                                $privilege['edit'] = 1;
                            }
                            if (array_key_exists('delete', $menu)) {
                                $privilege['delete'] = 1;
                            }
                            if (array_key_exists('other', $menu)) {
                                $privilege['other'] = 1;
                            }
                        }
                    }
                }
                // update privilege
                Privilege::where('id', $rolePrivilege->id)->update($privilege);
            }
        } else {
            return back()->with('error', 'Oops, something went wrong!');
        }
        return redirect('role')->with('success', 'Role Updated');
    }

    public function delete($id)
    {
        Privilege::where('role_id', $id)->delete();
        Role::where('id', $id)->delete();
        return redirect('/role')->with('success', 'Role Deleted');
    }

    public function fnGetData(Request $request)
    {
        // set page parameter for pagination
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data  = new Role();
        if ($request->session()->get('user_data')['role_id'] != 1) {
            $data = $data->where('id', '!=', 1);
        }

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
                $btn = '<a class="btn btn-default" href="role/' . $data->id . '">Edit</a>';
                $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;" onclick="fnDelete(this,' . $data->id . ')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}


