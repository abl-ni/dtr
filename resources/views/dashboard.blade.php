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
            <div class="col-md-7">
                <div class="panel panel-default">
                    <div class="panel-heading col-md-12">
                        <span class="col-md-6">Project</span>
                        <span class="col-md-3">Tickets</span>
                        <span class="col-md-3">Developers</span>
                    </div>
                    <div class="panel-body col-lg-12 bg-white padding-none">
                        @foreach($project as $project)
                        <a href="#" class="list-group-item">
                            <span>{{ $project->name }}</span>
                        </a>
                        @endforeach                      
                    </div>
                   
                </div>
            </div>
            <div class="col-md-5">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Panel title</h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Panel title</h3>
                    </div>
                    <div class="panel-body">
                        Panel content
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

