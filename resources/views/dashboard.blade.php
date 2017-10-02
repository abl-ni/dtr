@extends('layouts.app')

@section('content')

@if(Auth::user()->type == 'PM')
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
        <div class="col-lg-10 col-md-offset-1">
            @include('modals.create')
            @include('modals.update')
            @include('modals.delete')
            @include('modals.dev')

            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="panel-title font-weight-bold">Projects</span>
                    <button type="button" class="btn btn-primary btn-sm pull-right" data-id="{{ Auth::user()->id }}" data-toggle="modal" data-target="#add-project">Add Project</button>
                </div>
                <div class="panel-body">
                    <table class="table table-borderless table-responsive">
                        @if($project->isNotEmpty())
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
                        <tbody id="table-body">
                            @foreach($project as $project)    
                            <tr class="item{{$project->id}}">
                                <td>{{$project->id}}</td>
                                <td>{{$project->name}}</td>
                                <td>{{$project->PM()->first()->name}}</td>
                                <td>{{$project->TL()->first()->name}}</td>
                                <td>
                                    <a href="#" class="list_popover" id="{{$project->id}}" data-toggle="popover" title="Developers" data-html="true" data-content="">See List <span class="badge">{{ count($project->dev) }}</span></a>
                                </td>
                                <td>
                                    <div class="col-sm-12">
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
                                </td>
                            </tr>
                            @endforeach 
                            @else 
                            <h3 class="text-center">No Projects Yet.</h3>
                            @endif
                        </tbody>   
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@else
@include('inc.form')
@endif

@endsection

