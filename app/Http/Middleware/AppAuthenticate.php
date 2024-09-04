<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class AppAuthenticate
{

    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;

    }

    public function handle($request, Closure $next, $guard = null)
    {
        header('Access-Control-Allow-Origin: *');

        if ($this->auth->guard('app_user')->guest()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized API',
                'error_code' => 401,
            ], 200);
        }
        return $next($request);
    }
}
