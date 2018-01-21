<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Project;
use App\User;
use App\Dev;
use App\Dtr;
use Auth;
use Validator;
use Response;
use Carbon\Carbon;
use App\Events\TestEvent;

class ProjectController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function trigger(){
        $event = new TestEvent(1);
        broadcast($event);
        dd();
    }
    
    public function show($id)
    {
        $project = Project::where('id', $id)->first();
        $devs = $project->dev()->pluck('id');
        $logs = Dtr::whereIn('proj_devs_id', $devs)->get();
        $tickets = $logs->groupBy('task_no')->count();
        return view('project',compact('project', 'logs', 'tickets'));
    }

    public function addProject(Request $request) //done
    {
        $check = array();
        $validator = $request->validate([
            'projectname' => 'required|unique:projects,name',
            'pm' => 'required',
            'tl' => 'required',
            ],[
            'projectname.required' => 'Project Name field is required.',
            'projectname.unique' => 'Project Name already exists.',
            'pm.required' => 'Project Manager option is required.',
            'tl.required' => 'Team Leader option is required.'
            ]
        );

        $data = new Project();
        $data->name = $request->projectname;
        $data->added_by = Auth::id();
        $data->pm_id = $request->pm;
        $data->tl_id = $request->tl;
        $data->date_created = Carbon::now()->toDateString();
        $projectsaved = $data->save();
        
        if($request->tl != null)
        {
            $dev = new Dev();
            $dev->dev_id = $request->tl;
            $dev->proj_id = $data->id;
            $dev->date_created = Carbon::now()->toDateString();
            $devsaved = $dev->save();
        }else{
            $devsaved = false;
        }
        
        if(!$projectsaved && !$devsaved){
            $check = array(
                'success' => false, 
                'message' => 'Something went wrong!');
        } else {
            $check = array(
                'success' => true, 
                'message' => ucfirst(htmlentities($request->projectname)).' successfully added.');
        }

        echo json_encode($check);
    }
    
    public function getQuery(Request $req)
    {
        $id = Auth::id();
        
        if (User::find($id)->type == 'Dev')
        {
            $project = Dev::where('dev_id', $id)->get();
            $projDevArray = [];
            $projDevArray = array_pluck($project, 'proj_id');
            $project = Project::whereIn('id', $projDevArray)->get();
        }
        else 
        {
            $project = Project::all();
        }
        
        $projectCount = count($project);

        $dev = User::where('type', 'Dev')->get();
        $pm = User::orderByRaw("id = $id DESC")->where('type', 'PM')->get();
        $allPM = User::where('type', 'PM')->get();
        $today = Dtr::where('date_created', Carbon::now()->toDateString())->count();
        return view ('dashboard',compact('project', 'projectCount', 'dev', 'pm', 'allPM', 'today'));
    }

    public function projectList(){        
        $id = Auth::id();
        
        if (User::find($id)->type == 'Dev')
        {
            $projects = Dev::where('dev_id', $id)->get();
            $projDevArray = [];
            $projDevArray = array_pluck($project, 'proj_id');
            $project = Project::whereIn('id', $projDevArray)->get();
        }
        else 
        {
            $projects = Project::all();
        }

        $data = array();

        if($projects)
            foreach ($projects as $key => $value) {
                $data[$key][0][] = $projects[$key]->id;
                $data[$key][1][] = array('htmlentities' => htmlentities($projects[$key]->name), 'normal' => $projects[$key]->name);
                $data[$key][2][] = array('htmlentities' => ucwords(htmlentities($projects[$key]->PM()->first()->name)), 'normal' => ucwords($projects[$key]->PM()->first()->name));
                $data[$key][3][] = array('htmlentities' => ucwords(htmlentities($projects[$key]->TL()->first()->name)), 'normal' => ucwords($projects[$key]->TL()->first()->name));
                foreach ($dev = $projects[$key]->dev()->get() as $key1 => $value) {
                    $data[$key][4][] = array('username' => array('htmlentities' => ucwords(htmlentities($dev[$key1]->user->name)), 'normal' => ucwords($dev[$key1]->user->name)), 'userid' => $dev[$key1]->user->id, 'count' => count($dev));
                }   
                $data[$key][5][] = $projects[$key]->id; 
            }

            $table_data = array(
                "draw" => 1,
                "recordsTotal" => count($data),
                "recordsFiltered" => count($data),
                'data' => $data, 
                );

            echo json_encode($table_data);
    }
    
    public function updateProject(Request $request) //done
    {
        $check = array();
        $validator = $request->validate([
            'projectname' => 'required',
            'projectid' => 'required',
            'pm' => 'required',
            'dev' => 'required',
            ],[
            'projectname.required' => 'Project Name field is required.',
            'projectid.required' => 'Something went wrong. Try refreshing the page.',
            'pm.required' => 'Project Manager option is required.',
            'dev.required' => 'Team Leader option is required.'
            ]
        );

        $data = Project::find($request->projectid);
        $data->name = $request->projectname;
        $data->pm_id = $request->pm;
        $data->tl_id = $request->dev;
        $projsaved = $data->save();

        $exists = Dev::where('proj_id', $request->projectid)
            ->where('dev_id', $request->dev)
            ->first()?true:false;

        if(!$exists) {
            $devDB = new Dev();
            $devDB->dev_id = $request->dev;
            $devDB->proj_id = $request->projectid;
            $devDB->date_created = Carbon::now()->toDateString();
            $devDB->save();
        }
        
        if(!$projsaved){
            $check = array(
                'success' => false, 
                'message' => 'Something went wrong!');
        } else {
            $check = array(
                'success' => true, 
                'message' => 'Project has been updated successfully.');
        }

        echo json_encode($check);
    }
    
    public function deleteProject(Request $request) {
        $check = array();
        $validator = $request->validate([
            'projectid' => 'required'
            ],[
            'projectid.required' => 'Please select a project to delete.'
            ]
        );

        $projectname = Project::where('id', $request->projectid)
                                ->pluck('name')
                                ->first();

        if($projectname){
            Project::find($request->projectid)->delete();

            $check = array(
                'success' => true, 
                'message' => ucfirst(htmlentities($projectname)).' successfully deleted!');
        } else {
            $check = array(
                'success' => false, 
                'message' => 'Something went wrong!');
        }

        echo json_encode($check);
    }
    
    public function getDev(Request $req)
    {
        $project = Project::find( $req->id);
        $dev = $project->dev;
        $devArray = [];
        $devArray = array_pluck($dev, 'dev_id');

        $selectDev = User::where([
            ['id', '!=', $project->tl_id],
            ['type', 'Dev']])
            ->whereNotIn('id', $devArray)
            ->get();

          return (object)$selectDev;
    }
    
}
