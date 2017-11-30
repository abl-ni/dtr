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
        $this->validate($request, [
                'ticket_number' => 'required|max:255',
                'task_title' => 'required|max:255',
                'hrs_rendered' => 'required|numeric|max:255',
            ]);

        $data = new Dtr ();
        
        $user_id = Auth::id();
        $id = Dev::where('proj_id', $request->projectid)
            ->where('dev_id', $user_id)
            ->pluck('id')
            ->first();
       
        $data->proj_devs_id = $id;
        $data->task_title = $request->task_title;
        $data->ticket_no = $request->ticket_number;
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
