<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAttend;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class UserAttendController extends Controller{

    public function check_in(Request $request)
    {
            $user=Auth::guard('app_user')->user();

            $check_in = UserAttend::create([
                'user_id' =>$user->id,
                'check_in_datetime' =>Carbon::now()->format('Y-m-d H:i:s')
            ]);

            // Return success response
            $data = [
                'check_in_id' => $check_in->id,
            ];

            return response()->json([
                'status'=>true,
                'message' => 'Check IN Successfully',
                'data'=>$data

            ], 200);


    }

}
