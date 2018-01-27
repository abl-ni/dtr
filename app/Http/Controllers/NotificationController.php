<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Dtr;
use Auth;
use App\Events\ResponseEvent;
use App\Events\RequestUpdateEvent;

class NotificationController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function action(Request $request, $option = null){
        $validator = $request->validate([
            'id' => 'required|integer',
            ],[
            'id.required' => 'Something went wrong.'
            ]
        );

    	if($option === 'approve'){
    		$notification = Notification::find($request->id);

    		if($notification){
	    		$dtr = Dtr::find($notification->dtr_id);
	    		$hrs_update = $dtr->hours_rendered + $notification->overtime;

	    		$data = array(
	                'hours_rendered' => $hrs_update,
	                );

	            $dtr->update($data);

	            $data = array();
	            $data = array(
	                'dtr_id' => $dtr->id, 
	                'notification_type' => 'reply', 
	                'overtime' => $notification->overtime, 
	                'message' => 'Overtime request approved.', 
	                'status' => 1, 
	                'user_id' => $notification->user_id, 
	                'requested_by' => $notification->requested_by, 
	                'approved_by' => Auth::id(), 
	                );

	            $reply_notif = Notification::create($data);

	            $data = array();
	            $data = array(
	            	'approved_by' => Auth::id(), 
	            	);

	            Notification::where('dtr_id', $dtr->id)->update($data);

		        $event = new ResponseEvent([
		        	'user' => $notification->requested_by,
		        	'notification' => array(
                        'notifications' => Notification::with('approved_by')->where('id', $reply_notif->id)->first(),
                        'time' => time_elapsed_string($reply_notif->created_at)
                        )
		        	]);
		        
		        broadcast($event)->toOthers();

                $notifyUsers = Notification::where('dtr_id', $dtr->id)->where('notification_type', 'request')->pluck('user_id');

                foreach ($notifyUsers as $user) {
                    $event = new RequestUpdateEvent([
                        'user' => $user,
                        ]);

                    broadcast($event)->toOthers();
                }
    		}
    	} else if($option === 'cancel'){
            $notification = Notification::find($request->id);

            if($notification){
                $dtr = Dtr::find($notification->dtr_id);
                // $hrs_update = $dtr->hours_rendered + $notification->overtime;

                // $data = array(
                //     'hours_rendered' => $hrs_update,
                //     );

                // $dtr->update($data);

                $data = array();
                $data = array(
                    'dtr_id' => $dtr->id, 
                    'notification_type' => 'reply', 
                    'overtime' => $notification->overtime, 
                    'message' => 'Overtime request cancelled.', 
                    'status' => 0, 
                    'user_id' => $notification->user_id, 
                    'requested_by' => $notification->requested_by, 
                    'approved_by' => Auth::id(), 
                    );

                $reply_notif = Notification::create($data);

                $data = array();
                $data = array(
                    'approved_by' => Auth::id(), 
                    );

                Notification::where('dtr_id', $dtr->id)->update($data);

                $event = new ResponseEvent([
                    'user' => $notification->requested_by,
                    'notification' => array(
                        'notifications' => Notification::with('approved_by')->where('id', $reply_notif->id)->first(),
                        'time' => time_elapsed_string($reply_notif->created_at)
                        )
                    ]);
                
                broadcast($event)->toOthers();

                $notifyUsers = Notification::where('dtr_id', $dtr->id)->where('notification_type', 'request')->pluck('user_id');

                foreach ($notifyUsers as $user) {
                    $event = new RequestUpdateEvent([
                        'user' => $user,
                        ]);

                    broadcast($event)->toOthers();
                }
            }
        }
    }

    public function get($options){
    	if($options){
    		$data = array();
    		$notifications = notifications($options);

    		foreach ($notifications as $notification) {
    			$data[] = array(
    				'notifications' => $notification, 
    				'time' => time_elapsed_string($notification->updated_at), 
    			);
    		}

    		echo json_encode($data);
    	}
    }

    public function test()
    {
        $notification = Notification::find(500);
        // $approved = count($notification->whereNotNull('approved_by')->get());
        echo json_encode($notification);
    }
}
