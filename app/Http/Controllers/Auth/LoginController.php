<?php

namespace App\Http\Controllers\Auth;

use App\Services\Gateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    private $role = [
        'email' => 'required|email|string',
        'password' => 'required|string|min:4',
    ];

    public function showLoginForm()
    {
        $username = $this->username();

        return view('auth.login', compact('username'));
    }

    private function username()
    {
        return 'email';
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


