<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Models\UserAttend;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserNotificationController extends Controller{

    public function store(Request $request)
    {
        // dd($request);
        $previousMonth = Carbon::now()->subMonth();
        $startDate = $previousMonth->startOfMonth()->toDateString();
        $endDate = $previousMonth->endOfMonth()->toDateString();

        $working_hours = UserAttend::where('user_id',$request->user_id)->whereBetween(DB::raw('DATE(updated_at)'), [$startDate, $endDate])->sum('working_hours');


        $user_notify=UserNotification::create([
            'user_id'=>$request->user_id,
            'title'=>"Working Hours",
            'body'=>"The total number of hours that you worked in the previouse month is ".$working_hours
        ]);

        return response()->json([
            'status'=>true,
            'message' => 'Notify Successfully',

        ], 200);


    }

    public function index(Request $request)
    {


        $data=UserNotification::get();
        if($request->user_id)
        {
            $data=UserNotification::where('user_id',$request->user_id)->get();
        }

        return response()->json([
            'status'=>true,
            'data' =>$data,

        ], 200);
    }

}
