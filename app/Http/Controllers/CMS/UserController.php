<?php

namespace App\Http\Controllers\CMS;

use App\Services\Gateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use \Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        return view('pages.Administrator.User.index');
    }

    public function create()
    {
        $roles = Role::where('role_id', '!=', 1)->get()->toArray();
        return view('pages.Administrator.User.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $param = $request->except('_token', 'photo');
        $validator = Validator::make($param, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $messages = [];
            foreach ($errors as $key => $value) {
                $messages = $value[0];
            }
            return back()->with('error', $messages);
        }

        $param['avatar'] = '';
        if($request->file('photo')){
            $file= $request->file('photo');
            $filename= time().'.'.$request->photo->extension();
            $file->move(public_path('img/avatars'), $filename);
            $param['avatar']= url('img/avatars').'/'.$filename;
        }

        $create = User::create($param);

        if ($create) {
            return redirect('admin')->with('success', 'User Created');
        }
        return back()->with('error', 'Oops, something went wrong!');
    }

    public function edit($id)
    {
        $roles = Role::where('role_id', '!=', 1)->get()->toArray();
        $user = User::where('user_id', $id)->first()->toArray();
        return view('pages.Administrator.User.edit', ['roles' => $roles, 'user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $param = $request->except('_token', 'photo');
        $validator = Validator::make($param, [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->messages();
            $messages = [];
            foreach ($errors as $key => $value) {
                $messages = $value[0];
            }
            return back()->with('error', $messages);
        }

        if($request->file('photo')){
            $file= $request->file('photo');
            $filename= time().'.'.$request->photo->extension();
            $file->move(public_path('img/avatars'), $filename);
            $param['avatar']= url('img/avatars').'/'.$filename;
        }

        if ($request->has('password')) {
            $param['password'] = Hash::make($request->input('password'));
        }

        $update = User::where('user_id', $id)->update($param);

        if ($update) {
            return redirect('admin')->with('success', 'User Updated');
        }
        return back()->with('error', 'User not Updated');
    }

    public function delete($id)
    {
        return redirect('/admin');
    }

    public function fnGetData(Request $request)
    {
        // set page parameter for pagination
        $page = ($request->start / $request->length) + 1;
        $request->merge(['page' => $page]);

        $data  = new User();
        $data = $data->where('role_id', '!=', 1)->with('role');

        if ($request->input('search')['value'] != null && $request->input('search')['value'] != '') {
            $data = $data->where('email', 'LIKE', '%'.$request->keyword.'%')->orWhere('username', 'LIKE', '%'.$request->keyword.'%')
            ->whereHas('role', function ($query) use($request) {
                $query->where('name', 'LIKE', '%'.$request->keyword.'%');
            });
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
            ->addColumn('avatar', function ($data) {
                return '<img src="'. $data->avatar .'" class="img-circle" style="width:50px">';
            })
            ->addColumn('action', function ($data) {
                $btn = '<a class="btn btn-default" href="admin/' . $data->user_id . '">Edit</a>';
                $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;" onclick="fnDelete(this,' . $data->user_id . ')">Delete</button>';
                return $btn;
            })
            ->rawColumns(['avatar', 'action'])
            ->make(true);
    }
}


