@extends('layouts.app')

@section('content')

@if (Auth::user()->type == 'Dev')
         @include('inc.form')
    @else
        @include('modals.create')
        @include('modals.update')
         <div class="container">
             <div class="row">
                 <div class="col-lg-10 col-lg-offset-1">
                     <div class="panel panel-default">
                         <div class="panel-heading">
                             <a class="panel-title">Projects</a>
                             <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#add-project">
                                 Add Project</button>
                         </div>
                         <div class="panel-body">
                             <div class="list-group" id="project-list">
                                @foreach ($data as $project)
                                 <a id="{{$project->id}}" name="{{$project->name}}" data-id="{{Auth::user()->id}}" class="list-group-item project-item">{{$project->name}}</a>
                                @endforeach
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
    @endif
@endsection
