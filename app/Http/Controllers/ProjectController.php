<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Validator;
use Response;

class ProjectController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function addProject(Request $request)
    { 
        $data = new Project ();
        $data->name = $request->name;
        $data->save ();
        return response ()->json ( $data );  
    }
    
    public function readProject(Request $req)
    {
        $data = Project::all ();
        return view ( 'dashboard' )->withData ( $data );
    }
    
    public function updateProject(Request $req) 
    {
        $data = Project::find ( $req->id );
        $data->name = $req->name;
        $data->save ();
        return response ()->json ( $data );
    }
}
