<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller{


    public function login(Request $request)
    {
        $rules = [

            'user_id' => 'required',
            'password'=>'required|min:6'
        ] ;

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails())
        {
             return response()->json([
                'status' => false,
                'error_code' => 422,
                'errors' => $validator->errors(),
            ],  200);
        }

        $credentials = [
            'user_id'=>$request->user_id,
            'password'=>$request->password
             ];

        if (! $token = Auth::guard('app_user')->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized User',
                'status' => false,
                'error_code' => 401],
                 200);
        }

        $user=Auth::guard('app_user')->user();

        return response()->json([
            'message' => 'Logged successfully',
            'auth_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60000000,
            'data' => $user,
        ]);

    }

}
