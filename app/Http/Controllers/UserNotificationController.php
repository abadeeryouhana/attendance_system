<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserNotification;
use App\Models\UserAttend;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Messaging\MulticastSendReport;

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

        $request['title']="Working Hours";
        $request['body']="The total number of hours that you worked in the previouse month is ".$working_hours;

        // Make push notification
        $send_notify=$this->send_to_token($request);

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

    public function send_to_token(Request $request)
    {
        $token=UserDevice::where('user_id',$request->user_id)->get();
        $data = [];

        $tokens=[];
        foreach($token as $item)
        {
            $tokens[]=$item->fcm_token;

        }

        $data=$this->send_notification_tokens($tokens,$request->title,json_encode($request->body));

            return response()->json([
                'status'=>true,
                'data'=>$data

            ], 200);

    }
    function send_notification_tokens($device_tokens, $title, $message){
        $factory = (new Factory)->withServiceAccount(public_path('path-to-your-firebase-service-account.json'));

        $messaging = $factory->createMessaging();

        $notification = Notification::create($title, $message);

            $message = CloudMessage::new()->withNotification($notification);

                try {
                    $result = $messaging->sendMulticast($message, $device_tokens);
                    if ($result->hasFailures()) {
                        foreach ($result->failures()->getItems() as $failure) {
                            return $failure->error()->getMessage().PHP_EOL;
                        }
                    }
                    return $result;
                } catch (\Exception $e) {
                    error_log('Notification sending failed: ' . $e->getMessage());
                    return $e->getMessage();
                }

    }

}
