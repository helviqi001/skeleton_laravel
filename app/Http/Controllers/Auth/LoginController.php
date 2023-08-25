<?php

namespace App\Http\Controllers\Auth;

use App\Services\Gateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use App\Models\User;
use App\Models\Privilege;
use App\Models\MenuGroup;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $user = User::where('email', $request->input('email'))->orWhere('username', $request->input('email'))->first();

        if ($user) {
            if (Hash::check($request->input('password'), $user->password)) {
                // set user login data to session
                $userData['user_id'] = $user->user_id;
                $userData['name'] = $user->name;
                $userData['email'] = $user->email;
                $userData['avatar'] = $user->avatar;
                $userData['role_id'] = $user->role_id;
                $payload = [
                    'iat' => time(),
                    'exp' => time() + 60 * 60 * 24,
                    'data' => $userData
                ];
                $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
                Session::put('token', $token);
                Session::put('user_data', $payload['data']);

                // set user login privilege
                $menus = MenuGroup::with('menu_item')->get()->toArray();
                $permissions = Privilege::where('role_id', $user->role_id)->where('view', 1)->get()->toArray();
                $privileges = [];
                foreach ($menus as $keyX => $menu) {
                    foreach ($menu['menu_item'] as $keyY => $menu_item) {
                        $viewable = false;
                        foreach ($permissions as $keyZ => $permission) {
                            if ($permission['menu_item_id'] == $menu_item['menu_item_id']) {
                                $viewable = true;
                            }
                        }
                        if ($viewable) {
                            $privileges[$keyX]['name'] = $menu['name'];
                            $privileges[$keyX]['icon'] = $menu['icon'];
                            $privileges[$keyX]['menus'][$keyY]['name'] = $menu_item['name'];
                            $privileges[$keyX]['menus'][$keyY]['url'] = $menu_item['url'];
                        }
                    }
                }
                Session::put('privileges', $privileges);

                return redirect('dashboard');
            }
        }
        $errors = array('email' => 'Wrong Username/Email or Password');
        return view('auth.login', compact('errors'));
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();

        return redirect('/login');
    }
}


