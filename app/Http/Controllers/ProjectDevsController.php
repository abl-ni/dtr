<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dev;
use App\User;
use App\Project;
use Carbon\Carbon;
    
class ProjectDevsController extends Controller
{
    public function addDev(Request $request)
    { 
        $dataSet = [];
        foreach($request->data as $dev){
            $dataSet[] = [
                'proj_id' => $request->id,
                'dev_id' => $dev,
                'date_created' => Carbon::now()->toDateString()
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
            ['type', 'Dev']
        ])
            ->whereIn('id', $devArray)
            ->get();
        
        return $selectDev;
    }
    
    
    public function removeDev(Request $request, $id)
    {
        $username = User::where('id', $request->userid)
                        ->where('type', 'Dev')
                        ->pluck('name')
                        ->first();
        
        $project = Project::where('id', $id)
                        ->first();
        
        if($request->userid == $project->tl_id){
            return back()->withErrors(["Error!","You cannot remove Project's Team Leader! Try updating the project."]);
        }
        
        Dev::where('proj_id', $id)
            ->where('dev_id', $request->userid)
            ->delete();
        
        return back()->with('success', ucfirst($username).' successfully remove in '.ucfirst($project->name).'!');
    }
}
