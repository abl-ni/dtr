<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Dev;
use App\User;
use App\Project;
use App\Dtr;
use App\Notification;
use Auth;
use Carbon\Carbon;
use App\Events\RequestEvent;

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

        $timestamp = Carbon::now();

        $user_id = Auth::id();
        $check = array();
            
        $project = Project::where('id', $request->projectid)->first();
        $admin = User::where('type', 'Admin')->pluck('id');
        $notifyTo = array($admin, $project->tl()->pluck('id'), $project->pm()->pluck('id'));

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

            $data = array(
                'proj_devs_id' => $id,
                'task_title' => $request->task_title,
                'ticket_no' => $request->ticket_number,
                'roadblock' => $request->roadblock,
                'hours_rendered' => $hrs_rendered,
                'date_created' => Carbon::now()->toDateString(),
                );

            $saved = Dtr::create($data);

            if ($overtime > 0) {
                $data = array();

                foreach ($notifyTo as $key => $value) {
                    $data[$key] = array(
                        'dtr_id' => $saved->id, 
                        'overtime' => $overtime, 
                        'message' => 'Overtime pending for approval', 
                        'status' => 1, 
                        'user_id' => $value[0], 
                        'requested_by' => $user_id, 
                        'created_at' => $timestamp, 
                        'updated_at' => $timestamp, 
                        );

                    foreach ($notifyTo as $key => $value) {
                        $data = array(
                            'dtr_id' => $saved->id, 
                            'overtime' => $request->hrs_rendered, 
                            'message' => 'Overtime pending for approval', 
                            'status' => 1, 
                            'user_id' => $value[0], 
                            'requested_by' => $user_id
                            );

                        $request_notif = Notification::create($data);
                        $event = new RequestEvent([
                            'user' => $request_notif->user_id,
                            'notifications' => Notification::with('requested_by')->where('id', $request_notif->id)->first(),
                            'time' => time_elapsed_string($request_notif->created_at),
                            ]);
                        
                        event($event);
                    }
                }

                $check = array(
                    'success' => true, 
                    'message' => 'Overtime for approval.');
            }
        } else {
            $data = array(
                'proj_devs_id' => $id,
                'task_title' => $request->task_title,
                'ticket_no' => $request->ticket_number,
                'roadblock' => $request->roadblock,
                'hours_rendered' => 0,
                'overtime?' => 'true',
                'date_created' => Carbon::now()->toDateString(),
                );

            $saved = Dtr::create($data);

            $data = array();

            foreach ($notifyTo as $key => $value) {
                $data = array(
                    'dtr_id' => $saved->id, 
                    'overtime' => $request->hrs_rendered, 
                    'message' => 'Overtime pending for approval', 
                    'status' => 1, 
                    'user_id' => $value[0], 
                    'requested_by' => $user_id
                    );

                $request_notif = Notification::create($data);
                $event = new RequestEvent([
                        'user' => $request_notif->user_id,
                        'notifications' => Notification::with('requested_by')->where('id', $request_notif->id)->first(),
                        'time' => time_elapsed_string($request_notif->created_at),
                        ]);
                
                event($event);
            }

            $check = array(
                'success' => true, 
                'message' => 'Overtime for approval.');
        }

        if($check){
            echo json_encode($check);

            return;
        }

        if(!$saved){
            $check = array(
                'success' => false, 
                'message' => 'Something went wrong!');
        } else {
            $check = array(
                'success' => true, 
                'message' => 'Logs has been added successfully.');
        }

        echo json_encode($check);
    }
}
