<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                'projectid' => 'required',
                'ticket_number' => 'required|numeric',
                'task_title' => 'required|max:255',
                'hrs_rendered' => 'required|numeric|greater_than_field:0',
            ]);

        $user_id = Auth::id();

        $id = Dev::where('proj_id', $request->projectid)
            ->where('dev_id', $user_id)
            ->pluck('id')
            ->first();

        $query = DB::table('dtrs')
                ->select(DB::raw('sum(dtrs.hours_rendered) as hrs_rendered'))
                ->join('devs', 'dtrs.proj_devs_id', '=', 'devs.id')
                ->where('devs.dev_id', '=', $user_id)
                ->where('dtrs.date_created', '=', Carbon::now()->toDateString())
                ->get();
        
        $prev_hrs_rendered = $query[0]->hrs_rendered;

        if(($remaining = 8 - $prev_hrs_rendered) > 0) {
            $overtime = $request->hrs_rendered - $remaining;

            if ($remaining == $request->hrs_rendered || $remaining < $request->hrs_rendered){
                $hrs_rendered = $remaining;
            } else if ($remaining > $request->hrs_rendered){
                $hrs_rendered = $request->hrs_rendered;
            }

            $data = new Dtr ();       
            $data->proj_devs_id = $id;
            $data->task_title = $request->task_title;
            $data->ticket_no = $request->ticket_number;
            $data->roadblock = $request->roadblock;
            $data->hours_rendered = $hrs_rendered;
            $data->date_created = Carbon::now()->toDateString();
            $saved = $data->save ();

            // if ($overtime > 0) {
            //     echo json_encode("overtime: ".$overtime);
            // }
        } else {
            // echo json_encode("overtime: ".$overtime);
        }

        if(!$saved){
            $check = array(
                'success' => false, 
                'message' => 'Something went wrong!');
        } else {
            $check = array(
                'success' => true, 
                'message' => 'Logs has been added successfully.'.$data->id);
        }

        echo json_encode($check);
    }
}
