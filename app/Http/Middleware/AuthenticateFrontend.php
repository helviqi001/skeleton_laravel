<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthenticateFrontend extends Middleware
{
    /**
     * The authentication factory instance.
     *
     * @var Auth
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param Auth $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string[] ...$guards
     * @return mixed
     *
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $session = $request->header('Authorization');
        
        if (!empty($session)) {
            $decode = JWT::decode($session, new Key(env('JWT_SECRET'), 'HS256'));
            if (Carbon::now()->format("Y-m-d H:i:s") <= Carbon::createFromTimestamp($decode->exp)->format('Y-m-d H:i:s')) {
                $request->user = $decode->data;
                return $next($request);
            } else {
                $data['success'] = false;
                $data['message'] = 'Token expired';
                $data['data'] = (object) array();
                return response()->json($data, 400);
            }
        }
        $data['success'] = false;
        $data['message'] = 'Token not provided';
        $data['data'] = (object) array();
        return response()->json($data, 400);
    }

    /**
     * Handle an unauthenticated user.
     *
     * @param Request $request
     * @param array $guards
     * @return void
     *
     * @throws AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectTo($request)
        );
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
