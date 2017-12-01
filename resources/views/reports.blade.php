@extends('layouts.app')

@section('content')

<div class="row dash-nav">
    <div class="dash-navbar col-md-12">
        <ul class="nav nav-pills nav-justified">
            @if (Auth::user()->type == 'Admin')            
            <li class="nav-item"><a class="nav-link" href="{{ url('dashboard') }}">Projects</a></li>
            <li class="nav-item active"><a class="nav-link" href="{{ url('reports') }}">Reports</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('users') }}">Users</a></li>
            @elseif (Auth::user()->type == 'Dev')
            <li class="nav-item"><a class="nav-link" href="{{ url('dashboard') }}">Record Ticket</a></li>
            <li class="nav-item active"><a class="nav-link" href="{{ url('reports') }}">Reports</a></li>
            @elseif (Auth::user()->type == 'PM')
            <li class="nav-item"><a class="nav-link" href="{{ url('dashboard') }}">Projects</a></li>
            <li class="nav-item active"><a class="nav-link" href="{{ url('reports') }}">Reports</a></li>
            @endif
        </ul>
    </div>
</div>
<div class="dashboard-container">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading col-md-12">
                    <form method="post">
                        <div class="col-md-2 col-sm-12">
                            <span class="panel-title font-weight-bold">Reports</span>
                        </div>
                        <div class="col-md-10">
                            <div class="col-md-1 col-sm-12 pull-right">
                                <button type="button" class="form-control" id="filterGo-btn">Go</button>
                            </div>
                            <div class="col-md-4 col-sm-12 pull-right">
                                <div id="reportrange" class="pull-right">
                                    <i class="icon icon-calendar"></i>&nbsp;
                                    <span></span> <b class="caret"></b>
                                    <input type="hidden" id="start">
                                    <input type="hidden" id="end">
                                </div>    
                            </div>
                            <div class="col-md-4 col-sm-12 pull-right">
                                <select id="groupBy" class="selectpicker pull-right">
                                    @if(Auth::user()->type !== 'Dev')
                                    <option data-icon="icon icon-user"> Group by Developers</option>
                                    @endif
                                    <option data-icon="icon icon-folder"> Group by Projects</option>
                                    <option data-icon="icon icon-film"> Group by Tickets</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-body" id="filter-body">
                    <table class="table" cellspacing="0" width="100%">
                        @if($result->isNotEmpty())
                        <thead>
                            <tr>
                                <th class="col-md-1">Name</th>
                                <th class="col-md-1">Project Name</th>
                                <th class="col-md-1">Ticket #</th>
                                <th class="col-md-1">Task Title</th>
                                <th class="col-md-2">Roadblock</th>
                                <th class="col-md-1">Date</th>
                                <th class="col-md-1">Hours</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach($result as $result)   
                            <tr class="item{{$result->id}}">
                                <td>{{$result->name}}</td>
                                <td>{{$result->project_name}}</td>
                                <td>{{$result->ticket_no}}</td>
                                <td>{{$result->task_title}}</td>
                                <td>{{$result->roadblock}}</td>
                                <td>{{$result->date_created}}</td>
                                <td>{{$result->hours_rendered}}</td>
                            </tr>

                            @endforeach 
                            @else 
                            <h3 style="padding-top:50px" class="text-center">No Results Found.</h3>
                            @endif

                        </tbody>   
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading col-md-12">
                    <div class="col-md-12">
                        <span class="panel-title font-weight-bold">Total Hours per Project</span>
                    </div>
                </div>
                <div class="panel-body" id="filter-body">
                    <div class="col-md-12">
                        <canvas id="myChart" height="200px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
