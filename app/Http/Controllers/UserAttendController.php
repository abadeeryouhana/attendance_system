<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAttend;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
    public function check_out(Request $request,$id)
    {
        $check_in = UserAttend::find($id);
        if (!$check_in) {
            return response()->json([
                'status' => false,
                'error_code' => 422,
                'errors' => "Invalid ID",
            ]);
        }

        $check_in->check_out_datetime=Carbon::now()->format('Y-m-d H:i:s');
        $check_out_datetime = Carbon::parse(Carbon::now()->format('Y-m-d H:i:s'));
        $check_in_datetime = Carbon::parse($check_in->check_in_datetime);

        // Get the difference in hours
        $hoursDifference = $check_out_datetime->diffInHours($check_in_datetime);
        $check_in->working_hours=$hoursDifference;
        $check_in->save();

        // Return success response
        return response()->json([
            'status'=>true,
            'message' => 'Check OUT Successfully',
            'data'=>$check_in

        ], 200);


    }

    public function get_working_hours(Request $request)
    {
        $rules = [

            'from_date' => 'required',
            'to_date'=>'required'
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

        $user=Auth::guard('app_user')->user();
        $from_date =  date('Y-m-d', strtotime($request->from_date));
        $to_date =  date('Y-m-d', strtotime($request->to_date));

        $working_hours = UserAttend::where('user_id',$user->id)->whereBetween(DB::raw('DATE(updated_at)'), [$from_date, $to_date])->sum('working_hours');

        // Return success response
        return response()->json([
            'status'=>true,
            'message' => 'Success',
            'total_number_of_hours'=>(int)$working_hours

        ], 200);


    }

}
