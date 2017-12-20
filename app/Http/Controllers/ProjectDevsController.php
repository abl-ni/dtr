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
        $validator = $request->validate([
            'data' => 'required',
            'id' => 'required'
            ],[
            'data.required' => 'Select at least one developer.',
            'id.required' => 'No project is selected.',
            ]
        );
        $check = array();
        $devsaved = false;
        $devDB = new Dev();
        $dataSet = [];

        foreach($request->data as $dev){
            $unique = Dev::where('proj_id', $request->id)
                    ->where('dev_id', $dev)
                    ->first()?false:true;

            if($unique) {
                $devDB->dev_id = $dev;
                $devDB->proj_id = $request->id;
                $devDB->date_created = Carbon::now()->toDateString();
                $devsaved = $devDB->save();
            }
        }

        if($devsaved){
            $check = array(
                'success' => true, 
                'message' => 'Developer successfully added to the project.');
        } else {
            $check = array(
                'success' => false, 
                'message' => 'Something went wrong! ');
        }

        echo json_encode($check);
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
    
    
    public function removeDev(Request $request)
    {   
        $validator = $request->validate([
            'userid' => 'required',
            'projectid' => 'required'
            ],[
            'userid.required' => 'No user is selected.',
            'projectid.required' => 'No project is selected.',
            ]
        );

        $check = array();

        $username = User::where('id', $request->userid)
                        ->where('type', 'Dev')
                        ->pluck('name')
                        ->first();
        
        $project = Project::where('id', $request->projectid)
                        ->first();
        
        if($username && $project) {
            if($request->userid == $project->tl_id){   
                $check = array(
                    'success' => false, 
                    'message' => "You cannot remove Project's Team Leader! Try updating the project."
                    );
            } else {            
                Dev::where('proj_id', $request->projectid)
                    ->where('dev_id', $request->userid)
                    ->delete();
                    
                $check = array(
                    'success' => true, 
                    'message' => ucwords($username).' has been deleted successfully.'
                    );
            }
        } else {
            $check = array(
                'success' => false, 
                'message' => 'Something went wrong.'
                );
        }

        echo json_encode($check);
    }
}
