<?php

namespace App\Http\Controllers;

use App\Services\Gateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use \Yajra\DataTables\DataTables;

class UserController extends Controller
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = new Gateway();
    }

    public function index()
    {
        return view('pages.Administrator.User.index');
    }

    public function create()
    {
        return view('pages.Administrator.User.create');
    }

    public function store()
    {

    }

    public function edit($id)
    {
        return view('pages.Administrator.User.edit');
    }

    public function update(Request $request, $id)
    {

    }

    public function delete($id)
    {
        return redirect('/admin');
    }

    public function fnGetData(Request $request)
    {
        $this->gateway->setHeaders([
            'Authorization' => 'Bearer ' . Session::get('auth')->token
        ]);
        $page = $request->input('start') / $request->input('length') + 1;
        $data = $this->gateway->get('/api/cms/manage/user', [
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
            ->addColumn('action', function ($q) {
                $btn = '<a class="btn btn-default" href="admin/' . $q->userId . '">Edit</a>';
                $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;" onclick="fnDelete(this,' . $q->userId . ')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}


