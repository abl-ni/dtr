@extends('layouts.app')

@section('content')

<div class="container">
<div class="page-header col-md-12">
  <div class="col-md-6">
    <h1>{{ $project->name }}</h1>
    <h5>Back to <a href="../dashboard">dashboard</a>.</h5>
  </div>
  <div class="col-md-6">
    <div class="col-md-4 text-center">
      <h4>Developers</h4>
      <h2>{{ $project->dev->count() }}</h2>
    </div>
    <div class="col-md-4 text-center">
      <h4>Tickets</h4>
      <h2>{{ $tickets }}</h2>
    </div>
    <div class="col-md-4 text-center">
      <h4>Logs</h4>
      <h2>{{ $logs->count() }}</h2>
    </div>
  </div>
</div>

<div class="col-md-12">
  <div class="col-md-6">
    <div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">PROJECT DETAILS</div>
    <div class="panel-body">
      <h5><strong>Added by : </strong>{{ ucwords($project->user->name) }}</h5>
      <h5><strong>Project Manager : </strong>{{ ucwords($project->PM->name) }}</h5>
      <h5><strong>Team Leader :</strong> {{ ucwords($project->TL->name) }}</h5>
      <h5><strong>Created at :</strong> {{ $project->date_created }}</h5>
    </div>

    </div>
  </div>
  <div class="col-md-6">
    <div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">DEVELOPERS</div>

    <!-- List group -->
    <ul class="list-group">
      @foreach ($project->dev as $devs)
      <li class="list-group-item">{{ ucwords($devs->user->name) }} 
        <button class="pull-right btn btn-danger btn-sm" type="button">Remove</button> 
      </li>
      @endforeach
    </ul>
    </div>
  </div>
</div>
  
</div>

<div class="col-md-12">
  <div class="col-md-6">
  </div>
</div>

</div>


@endsection