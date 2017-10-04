<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Response;
use Carbon\Carbon;


class FilterController extends Controller
{
    public function getQuery(Request $request)
    {
        $getDtrIds = DB::table('dtrs')->pluck('proj_devs_id');
        $current_time = Carbon::now()->toDateString();
        $getDevsDtrs = DB::table('devs')->select('dev_id')->groupBy('dev_id')->get();
        
        $result = DB::table('users')
            ->select('users.id','users.name', 'projects.name as project_name', 'dtrs.task_no', 
                     'dtrs.task_title', 'dtrs.hours_rendered', 'dtrs.date_created', 'dtrs.roadblock', 'dtrs.hours_rendered')
            ->leftJoin('devs', 'users.id', '=', 'devs.dev_id')
            ->leftJoin('projects', 'devs.proj_id', '=', 'projects.id')
            ->leftJoin('dtrs', 'devs.id', '=', 'dtrs.proj_devs_id')
            ->where('users.type', 'Dev')
            ->where('dtrs.date_created', $current_time)
            ->whereIn('devs.id', $getDtrIds)
            ->groupBy('dtrs.id')
            ->get();
            
        return view('reports', compact('result', 'getDevsDtrs'));
    }
    
    public function getFilter(Request $request)
    {
        $groupby = $request->groupby;
        $start = $request->starts;
        $end = $request->ends;
        $getDtrIds = DB::table('dtrs')->pluck('proj_devs_id');
        
        switch($groupby){
        
            case 'Group by Developers' :
            
                $result = DB::table('users')
                    ->select('users.id','users.name', 'projects.name as project_name', 'dtrs.task_no', 
                             'dtrs.task_title', 'dtrs.hours_rendered', 'dtrs.date_created', 'dtrs.roadblock', 'dtrs.hours_rendered')
                    ->leftJoin('devs', 'users.id', '=', 'devs.dev_id')
                    ->leftJoin('projects', 'devs.proj_id', '=', 'projects.id')
                    ->leftJoin('dtrs', 'devs.id', '=', 'dtrs.proj_devs_id')
                    ->where('users.type', 'Dev')
                    ->whereBetween('dtrs.date_created', [$start, $end])
                    ->whereIn('devs.id', $getDtrIds)
                    ->groupBy('users.id')
                    ->get();

                return $result;
            
            break;
            
            case 'Group by Projects' :
            
                $result = DB::table('users')
                    ->select('projects.id','projects.name', 'users.name as username', 'dtrs.task_no', 
                             'dtrs.task_title', 'dtrs.hours_rendered', 'dtrs.date_created', 'dtrs.roadblock', 'dtrs.hours_rendered')
                    ->leftJoin('devs', 'users.id', '=', 'devs.dev_id')
                    ->leftJoin('projects', 'devs.proj_id', '=', 'projects.id')
                    ->leftJoin('dtrs', 'devs.id', '=', 'dtrs.proj_devs_id')
                    ->where('users.type', 'Dev')
                    ->whereBetween('dtrs.date_created', [$start, $end])
                    ->whereIn('devs.id', $getDtrIds)
                    ->groupBy('dtrs.id')
                    ->get();

                return $result;
            
            break;
            
            case 'Group by Tickets' :
            
                $result = DB::table('users')
                    ->select('dtrs.task_no as id','projects.name as project_name', 'users.name as username',
                             'dtrs.task_title as name', 'dtrs.hours_rendered', 'dtrs.date_created', 'dtrs.roadblock', 'dtrs.hours_rendered')
                    ->leftJoin('devs', 'users.id', '=', 'devs.dev_id')
                    ->leftJoin('projects', 'devs.proj_id', '=', 'projects.id')
                    ->leftJoin('dtrs', 'devs.id', '=', 'dtrs.proj_devs_id')
                    ->where('users.type', 'Dev')
                    ->whereBetween('dtrs.date_created', [$start, $end])
                    ->whereIn('devs.id', $getDtrIds)
                    ->groupBy('dtrs.id')
                    ->get();

                return $result;
            
            break;
        
        }
    
    }
    
    
}
