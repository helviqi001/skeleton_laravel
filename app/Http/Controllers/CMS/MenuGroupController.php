<?php

namespace App\Http\Controllers\CMS;

use App\Services\Gateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use \Yajra\DataTables\DataTables;
use App\Models\MenuGroup;
use App\Models\MenuItem;

class MenuGroupController extends Controller
{
    public function index()
    {
        return view('pages.Configuration.MenuGroup.index');
    }

    public function create()
    {
        return view('pages.Configuration.MenuGroup.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        // insert new menu group
        $create = MenuGroup::create($data);
        if ($create) {
            return redirect('menu-group')->with('success', 'Menu Group Created');
        }
        return back()->with('error', 'Oops, something went wrong!');
    }

    public function edit($id)
    {
        $data = MenuGroup::where('id', $id)->first();

        return view('pages.Configuration.MenuGroup.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->except('_token');

        // insert new role
        $update = MenuGroup::where('id', $id)->update($data);
        if ($update) {
            return redirect('menu-group')->with('success', 'Menu Group Updated');
        }
        return back()->with('error', 'Oops, something went wrong!');
    }

    public function updateStatus($id)
    {
        $menuGroup = MenuGroup::where('id', $id)->first();

        if ($menuGroup) {
            if ($menuGroup->status == 0) {
                $menuGroup->status = 1;
            } else {
                $menuGroup->status = 0;
            }
            $menuGroup->save();
            return response()->json([
                'success' => true,
                'message' => 'Status updated',
                'data' => (object) array(),
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Oops, something went wrong!',
            'data' => (object) array(),
        ], 400);
    }

    public function delete($id)
    {
        MenuItem::where('menu_group_id', $id)->delete();
        MenuGroup::where('id', $id)->delete();
        return redirect('menu-group')->with('success', 'Menu Group Deleted');
    }

    public function fnGetData(Request $request)
    {
        // set page parameter for pagination
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data  = new MenuGroup();

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
            ->addColumn('status', function ($data) {
                if ($data->status == 0) {
                    $option = '<option value="0" selected>Inactive</option>
                    <option value="1">Active</option>';
                } else {
                    $option = '<option value="0">Inactive</option>
                    <option value="1" selected>Active</option>';
                }
                $element = '<select class="form-control" onchange="updateStatus('.$data->id.')">'.$option.'</select>';
                return $element;
            })
            ->addColumn('action', function ($data) {
                $btn = '<a class="btn btn-default" href="menu-group/' . $data->id . '">Edit</a>';
                $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;" onclick="fnDelete(this,' . $data->id . ')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}


