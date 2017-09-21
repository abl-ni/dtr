@extends('layouts.app')

@section('content')

@if (Auth::user()->type == 'Dev')
         @include('inc.form')
    @else
        @include('modals.create')
        @include('modals.update')
<div class="dashboard-container">
    <div class="row">
        <div class="col-lg-3">
            <div class="col-md-12">
                <ul class="dashboard-tab nav nav-pills nav-stacked text-center">
                    <li role="presentation" class="active">
                        <a href="#project-tab" data-toggle="tab" class="list-group-item">
                            PROJECTS
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#reports-tab" data-toggle="tab" class="list-group-item">
                            REPORTS
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-12 filter-container">
                <div class="panel panel-default filter">
                    filter search here
                </div>
            </div>
        </div>
        <div class="col-lg-9 tab-content">
            <div class="col-lg-12 tab-pane active" id="project-tab">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title font-weight-bold">Projects</span>
                        <button type="button" class="btn btn-primary btn-sm pull-right" data-id="{{ Auth::user()->id }}" data-toggle="modal" data-target="#add-project">
                            Add Project</button>
                    </div>
                    <div class="panel-body">
                        <table class="table table-borderless table-responsive">
                            <thead>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-3">Name</th>
                                    <th class="col-md-2">Developers</th>
                                    <th class="col-md-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                @foreach($data as $project)    
                                <tr class="item{{$project->id}}">
                                    <td>{{$project->id}}</td>
                                    <td>{{$project->name}}</td>
                                    <td><span class="badge">14</span></td>
                                    <td>
                                        <div class="col-sm-12">
                                            <button class="edit-modal btn btn-warning btn-sm col-sm-5 col-sm-offset-1" data-id="{{$project->id}}" data-name="{{$project->name}}" data-target="#update-project">
                                                Update
                                            </button>
                                            <button class="delete-modal btn btn-danger btn-sm col-sm-5 col-sm-offset-1" data-id="{{$project->id}}" data-name="{{$project->name}}" data-target="#delete-project">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach 
                            </tbody>   
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 tab-pane" id="reports-tab">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title font-weight-bold">Reports</span>
                    </div>

                    <div class="panel-body">
                        <table class="table table-list-search">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Project Name</th>
                                    <th>Ticket #</th>
                                    <th>Task Title</th>
                                    <th>Roadblock</th>
                                    <th>Hours Rendered</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @endif
@endsection
