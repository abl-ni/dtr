<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Validator;
use Response;

class FilterController extends Controller
{
    public function getQuery()
    {
        $getDtrIds = DB::table('dtrs')->pluck('proj_devs_id');
        
        $getDevsDtrs = DB::table('devs')->select('dev_id')->groupBy('dev_id')->get();
        
        $result = DB::table('users')
            ->select('users.id','users.name', 'projects.name as project_name', 'dtrs.task_no', 
                     'dtrs.task_title', 'dtrs.hours_rendered', 'dtrs.created_at', 'dtrs.roadblock', 'dtrs.hours_rendered')
            ->leftJoin('devs', 'users.id', '=', 'devs.dev_id')
            ->leftJoin('projects', 'devs.proj_id', '=', 'projects.id')
            ->leftJoin('dtrs', 'devs.id', '=', 'dtrs.proj_devs_id')
            ->where('users.type', 'Dev')
            ->whereIn('devs.id', $getDtrIds)
            ->groupBy('dtrs.id')
            ->get();
            
        return view('reports', compact('result', 'getDevsDtrs'));
    }
}
