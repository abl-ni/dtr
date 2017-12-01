@extends('layouts.app')
    
    
@section('content')

@include('modals.create')
@include('modals.update')
@include('modals.delete')
@include('modals.dev')
@include('modals.confirmRemove')

@if (Auth::user()->type == 'Admin')      
<div class="row dash-nav">
    <div class="dash-navbar col-md-12">
        <ul class="nav nav-pills nav-justified">
            <li class="nav-item active"><a class="nav-link" href="{{ url('dashboard') }}">Projects</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('reports') }}">Reports</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('users') }}">Users</a></li>
        </ul>
    </div>
</div>
<div class="dashboard-container">
    @include('inc.errors')
    @include('inc.success')
    <div class="row">
        <div class="col-lg-12">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title font-weight-bold">Projects</span>
                        <button type="button" 
                                class="btn btn-primary btn-sm pull-right" 
                                data-toggle="modal" 
                                data-target="#addProject-modal">Add Project</button>
                    </div>
                    <div class="panel-body col-lg-12 bg-white padding-none">
                        <table id="project-list" class="table table-borderless table-responsive" width="100%">
                            <thead>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-3">Name</th>
                                    <th class="col-md-2">Project Manager</th>
                                    <th class="col-md-2">Team Leader</th>
                                    <th class="col-md-2">Developers</th>
                                    <th class="col-md-2">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-3">Name</th>
                                    <th class="col-md-2">Project Manager</th>
                                    <th class="col-md-2">Team Leader</th>
                                    <th class="col-md-2">Developers</th>
                                    <th class="col-md-2">Actions</th>
                                </tr>
                            </tfoot>
                        </table>                                   
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
                        <h1 class="text-center"><strong>{{ $today }}</strong></h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@elseif (Auth::user()->type == 'PM')

    @include('inc.projects')

@elseif (Auth::user()->type == 'Dev')
    <div class="row dash-nav">
        <div class="dash-navbar col-md-12">
            <ul class="nav nav-pills nav-justified">
                <li class="nav-item active"><a class="nav-link" href="{{ url('dashboard') }}">Record Ticket</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('reports') }}">Reports</a></li>
            </ul>
        </div>
    </div>
    @include('inc.form')

@endif

@endsection

