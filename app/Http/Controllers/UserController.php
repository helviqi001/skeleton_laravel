<?php

namespace App\Http\Controllers;

use App\Services\Gateway;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private $role = [
        'email' => 'required|email|string',
        'password' => 'required|string|min:4',
    ];
    public function __construct()
    {
        $this->gateway = new Gateway();
    }

    public function index()
    {
        return view('pages.Administrator.User.index');
    }

    public function fnGetData(Request $request)
    {
        $this->gateway->setHeaders([
            'Authorization' => 'Bearer '.Session::get('auth')->token
        ]);
        $data = $this->gateway->get(env('GATEWAY_URL').'manage/user', [
            'page' => $request->input('draw'),
            'perPage' => $request->input('length'),
            'limit' => $request->input('length'),
            'keyword' => $request->input('search')['value'],
            'sortBy' => $request->input('columns')[$request->input('order')[0]['column']]['name'],
            'sort' => $request->input('order')[0]['dir']
        ])->getData()->data;

        if(!empty($data->items)){
            return DataTables::of($data->items)
                ->skipPaging()
                ->setTotalRecords($data->total)
                ->setFilteredRecords($data->total)
                ->addColumn('action', function ($q){
                    $btn = '<button class="btn btn-default btn-xs btnEdit" style="padding: 5px 6px;">Edit</button>';
                    $btn .= ' <button class="btn btn-danger btn-xs btnDelete" style="padding: 5px 6px;">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return false;
    }

    public function create()
    {

    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function delete()
    {

    }

    public function authenticate(Request $request)
    {

        $gateway = new Gateway();

        if (!\Cache::has('token-app')) {
            $token = $gateway->post('/api/token', [
                'clientKey' => 'clientKeyBackOffice',
                'secretKey' => 'secret'
            ]);

            \Cache::add('token-app', $token->getData()->data->token, 2592000);;
        }

        $this->validate($request, $this->role);
        $response = $gateway->post('/api/cms/login', $request->all())->getData();
        if (!$response->success) {
            $error = array('email' => $request['message']);
            $username = $this->username();

            return view('auth.login', compact('error', 'username'));
        }
        Session::put('auth', $response->data);

        $gateway = new Gateway();
        $responsePrivileges = $gateway->get('/api/cms/auth/my-privileges')->getData();
        Session::put('privileges', $responsePrivileges->data);

        return redirect('dashboard');
    }

    public function register(Request $request)
    {
        $gateway = new Gateway();
        $response = $gateway->Post('register', $request->only('name', 'email', 'password'));

        return response()->json($response, $response['code']);
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();

        return redirect('/login');
    }
}


