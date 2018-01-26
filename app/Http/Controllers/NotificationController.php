<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use App\Dtr;
use Auth;
use App\Events\ResponseEvent;

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
    		$approved = count($notification->where('dtr_id', $notification->dtr_id)->whereNotNull('approved_by')->get());

    		if(!$approved){
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
		        	'notification' => $reply_notif
		        	]);
		        
		        event($event);
    		}
    	}
    }

    public function get($options){
    	if($options){
    		$notifications = notifications($options);

    		foreach ($notifications as $notification) {
    			$data[] = array(
    				'notifications' => $notification, 
    				'time' => time_elapsed_string($notification->created_at), 
    			);
    		}

    		echo json_encode($data);
    	}
    }
}
