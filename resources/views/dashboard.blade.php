@extends('layouts.app')

@section('content')
@if (Auth::user()->type == 'Admin')

<div class="row dash-nav">
    <div class="dash-navbar col-md-4 col-md-offset-4">
        <ul class="nav navbar-nav col-md-12 text-center">
            <li class="col-md-6 ative"><a href="{{ url('dashboard') }}">Projects</a></li>
            <li class="col-md-6"><a href="{{ url('reports') }}">Reports</a></li>
        </ul>
    </div>
</div>
<div class="dashboard-container">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading col-md-12">
                        <span class="col-md-5">Project</span>
                        <span class="col-md-2">Tickets</span>
                        <span class="col-md-3">Developers</span>
                        <span class="col-md-1">Action</span>
                    </div>
                    <div class="panel-body col-lg-12 bg-white padding-none">
                        @foreach($project as $project)
                        <div class="list-group-item col-lg-12">
                            <a href="{{action('ProjectController@show', $project->id)}}" class="col-lg-10">
                                <span class="col-md-6">{{ $project->name }}</span>
                                <span class="col-md-3"><span class="badge">{{ $project->total_tickets }}</span></span>
                                <span class="col-md-3"><span class="badge">{{ $project->total_devs }}</span></span>
                            </a>
                            <div class="col-sm-2">
                                <button class="add-modal btn btn-info btn-sm" data-id="{{$project->id}}" data-name="{{$project->name}}" data-target="#add-dev" data-toggle="modal">
                                    <span class="icons icons icon-user-follow icon-modals"></span>
                                </button>
                                <button class="edit-modal btn btn-warning btn-sm" data-id="{{$project->id}}" data-name="{{$project->name}}" data-target="#update-project" data-toggle="modal">
                                    <span class="icons icon-pencil icon-modals"></span>
                                </button>
                                <button class="delete-modal btn btn-danger btn-sm" data-id="{{$project->id}}" data-name="{{$project->name}}" data-target="#delete-project" data-toggle="modal">
                                    <span class="icons icon-trash icon-modals"></span>
                                </button>
                            </div>
                            
                        </div>
                        @endforeach                      
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading ">
                        <h3 class="panel-title">TOTAL PROJECTS</h3>
                    </div>
                    <div class="panel-body">
                        <h1 class="text-center"><strong>{{ $projectCount }}</strong></h1>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Logs Today</h3>
                    </div>
                    <div class="panel-body">
                        <h1 class="text-center"><strong>0</strong></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@elseif (Auth::user()->type == 'PM')

    @include('inc.projects')

@else

    @include('inc.form')

@endif

@endsection

