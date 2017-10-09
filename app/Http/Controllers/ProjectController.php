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

class ProjectController extends Controller
{
    public function index()
    {
        return view('dashboard');
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
        $data = new Project();
        $data->name = $request->projectname;
        $data->added_by = Auth::id();
        $data->pm_id = $request->pm;
        $data->tl_id = $request->tl;
        $data->date_created = Carbon::now()->toDateString();
        $projectsaved = $data->save();
        
        $dev = new Dev();
        $dev->dev_id = $request->tl;
        $dev->proj_id = $data->id;
        $dev->date_created = Carbon::now()->toDateString();
        $devsaved = $dev->save();
        
        if(!$projectsaved || !$devsaved){
            return back()->withErrors(['error', 'Something went wrong!']);
        }
        
        return back()->with('success', ucfirst($request->projectname).' successfully added!');
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
    
    public function updateProject(Request $req, $id) //done
    {
        $data = Project::find($id);
        $data->name = $req->projectname;
        $data->pm_id = $req->pm;
        $data->tl_id = $req->dev;
        $projsaved = $data->save();
        
        $dev = Dev::where('proj_id', $id)->first();
        $dev->dev_id = $req->dev;
        $devsaved = $dev->save();

        
        if(!$projsaved || !$devsaved){
            return back()->withErrors(['error', ucfirst($req->projectname).'Unsuccessful! Something went wrong!']);
        }
        return back()->with('success', ucfirst($req->projectname).' successfully updated!');
    }
    
    public function deleteProject($id) { //done
        $projectname = Project::where('id', $id)
                                ->pluck('name')
                                ->first();
        Project::find($id)->delete();
        return back()->with('success', ucfirst($projectname).' successfully deleted!');
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
