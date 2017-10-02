<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dev;
use App\User;
use App\Project;
    
class ProjectDevsController extends Controller
{
    public function addDev(Request $request)
    { 
        $dataSet = [];
        foreach($request->data as $dev){
            $dataSet[] = [
                'proj_id' => $request->id,
                'dev_id' => $dev,
            ];
        }
        Dev::insert($dataSet);  
    }
    
    public function getListDev(Request $request)
    { 
        $devItem = new Dev();
        $devItem = Dev::where('proj_id', $request->id)->get();
        $devArray = [];
        $devArray = array_pluck($devItem, 'dev_id');
        $project = Project::find($request->id);

        $selectDev = User::where([
            ['id', '!=', $project->tl_id],
            ['type', 'Dev']
        ])
            ->whereIn('id', $devArray)
            ->get();
        
        return $selectDev;
    }
}