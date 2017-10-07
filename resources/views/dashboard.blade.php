@extends('layouts.app')

@section('content')
@if (Auth::user()->type == 'Admin')
      @include('modals.create')
      @include('modals.update')
      @include('modals.delete')
      @include('modals.dev')
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
                  <div class="panel-body col-lg-12 bg-white padding-none">
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
                                  <td><a href="{{ action('ProjectController@show', $project->id)}}">{{$project->name}}</a></td>
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

