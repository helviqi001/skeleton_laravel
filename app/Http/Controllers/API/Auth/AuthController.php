<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'  =>  'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed',
                'data' => $validator->errors(),
            ], 400);
        }

        $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();
        if (!$user) {
            $validator->errors()->add('email', 'Invalid Email/Username or Password');
            return response()->json([
                'success' => false,
                'message' => 'Login Failed',
                'data' => $validator->errors(),
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            $validator->errors()->add('email', 'Invalid Email/Username or Password');
            return response()->json([
                'success' => false,
                'message' => 'Login Failed',
                'data' => $validator->errors(),
            ], 404);
        }

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

        return response()->json([
            'success' => true,
            'message' => 'Login Success',
            'data' => ['token' => $token, 'user' => $user, 'current_date' => date('Y-m-d')],
        ], 200);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => User::where('user_id', $request->user->user_id)->with('role')->first()->toArray(),
        ], 200);
    }
}
