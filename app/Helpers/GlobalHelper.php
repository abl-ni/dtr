<?php

function notifications($option) {
	if(Auth::check()){
		if($option === 'request'){
			$data = App\Notification::where(['notification_type' => $option, 'user_id' => Auth::id(), 'approved_by' => null, 'status' => 1])
			->get();
		} else if($option === 'reply'){
			$data = App\Notification::where(['notification_type' => $option, 'requested_by' => Auth::id()])
				->whereNotNull('approved_by')
				->get();
		}
			
			return $data;
	}

	return false;
}