<?php

namespace App\Http\Controllers;

use App\Services\Gateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use \Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view('pages.Administrator.Role.index');
    }

    public function create()
    {
        $gateway = new Gateway();

        $menuItems = $gateway->get('/api/cms/manage/menu-item', [
            'limit' => 999
        ])->getData()->data->items;

        return view('pages.Administrator.Role.create', compact('menuItems'));
    }

    public function store()
    {

    }

    public function edit($id)
    {
        $gateway = new Gateway();

        $menuItems = $gateway->get('/api/cms/manage/menu-item', [
            'limit' => 999
        ])->getData()->data->items;

        return view('pages.Administrator.Role.edit', compact('menuItems'));
    }

    public function update(Request $request, $id)
    {

    }

    public function delete($id)
    {
        $gateway = new Gateway();

        $deleteRole = $gateway->delete('/api/cms/manage/role/' . $id);
        if (!$deleteRole->getData()->success) {
            return redirect('/role')->with('error', $deleteRole->getData()->message);
        }
        return redirect('/role')->with('success', 'Role Deleted');
    }

    public function fnGetData(Request $request)
    {
        $gateway = new Gateway();

        $page = $request->input('start') / $request->input('length') + 1;
        $data = $gateway->get('/api/cms/manage/role', [
            'page' => $page,
            'perPage' => $request->input('length'),
            'limit' => $request->input('length'),
            'keyword' => $request->input('search')['value'],
            'sortBy' => $request->input('columns')[$request->input('order')[0]['column']]['name'],
            'sort' => $request->input('order')[0]['dir']
        ])->getData()->data;

        return DataTables::of($data->items)
            ->skipPaging()
            ->setTotalRecords($data->total)
            ->setFilteredRecords($data->total)
            ->addColumn('action', function ($data) {
                $btn = '<a class="btn btn-default" href="role/' . $data->roleId . '">Edit</a>';
                $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;" onclick="fnDelete(this,' . $data->roleId . ')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}


