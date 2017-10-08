<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dev;
use App\User;
use App\Project;
use App\Dtr;
use Auth;
use Carbon\Carbon;

class DtrController extends Controller
{
    
    public function addLogs(Request $request)
    {        
        $data = new Dtr ();
        
        $user_id = Auth::id();
        $id = Dev::where('proj_id', $request->projectid)
            ->where('dev_id', $user_id)
            ->pluck('id')
            ->first();
       
        $data->proj_devs_id = $id;
        $data->task_title = $request->task_title;
        $data->task_no = $request->ticket_number;
        $data->roadblock = $request->roadblock;
        $data->hours_rendered = $request->hrs_rendered;
        $data->date_created = Carbon::now()->toDateString();
        $saved = $data->save ();
        
        if(!$saved){
            return back()->withErrors(['error', 'Something went wrong!']);
        }
        
        return back()->with('success', 'Logs successfully added!');
    }
}
