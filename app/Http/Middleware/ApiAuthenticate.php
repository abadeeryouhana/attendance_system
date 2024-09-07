<?php

namespace App\Http\Middleware;

use Closure;
// use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
class ApiAuthenticate
{

    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;

    }

    public function handle($request, Closure $next, $guard = null)
    {
        header('Access-Control-Allow-Origin: *');

        if(!empty($request->header('x-api-key')))
        {
            $apiKey = $request->header('x-api-key');

            if($apiKey !== env('X_API_KEY')) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid X-API-KEY',
                    'error_code' => 401,
                ], 200);
            }
        }
        else
        {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized API',
                'error_code' => 401,
            ], 200);
        }


        return $next($request);
    }
}
