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
                <div class="panel panel-success">
                    <div class="panel-heading col-md-12">
                        <span class="col-md-6">Project</span>
                        <span class="col-md-3">Tickets</span>
                        <span class="col-md-3">Developers</span>
                    </div>
                    <div class="panel-body col-lg-12 bg-white padding-none">
                        @foreach($project as $project)
                        <a href="{{ url('project/{$project->id}') }}" class="list-group-item col-lg-12">
                            <span class="col-md-6">{{ $project->name }}</span>
                            <span class="col-md-3"><span class="badge">67</span></span>
                            <span class="col-md-3"><span class="badge">67</span></span>
                        </a>
                        @endforeach                      
                    </div>

                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-success">
                    <div class="panel-heading ">
                        <h3 class="panel-title">TOTAL PROJECTS</h3>
                    </div>
                    <div class="panel-body">
                        <h1 class="text-center"><strong>89</strong></h1>
                    </div>
                </div>

                <div class="panel panel-success">
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

