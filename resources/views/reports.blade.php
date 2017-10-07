@extends('layouts.app')

@section('content')

@if (Auth::user()->type == 'Dev')
@include('inc.form')
@else
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
            <div class="panel panel-default">
                <div class="panel-heading col-md-12">
                    <form method="post">
                        <div class="col-md-2">
                            <span class="panel-title font-weight-bold">Reports</span>
                        </div>
                        <div class="col-md-10">
                            <div class="col-md-1 pull-right">
                                <button type="button" class="form-control" id="filterGo-btn">Go</button>
                            </div>
                            <div class="col-md-4 pull-right">
                                <div id="reportrange" class="pull-right">
                                    <i class="icon icon-calendar"></i>&nbsp;
                                    <span></span> <b class="caret"></b>
                                    <input type="hidden" id="start">
                                    <input type="hidden" id="end">
                                </div>    
                            </div>
                            <div class="col-md-4 pull-right">
                                <select id="groupBy" class="selectpicker pull-right">
                                    <option data-icon="icon icon-user"> Group by Developers</option>
                                    <option data-icon="icon icon-folder"> Group by Projects</option>
                                    <option data-icon="icon icon-film"> Group by Tickets</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-body" id="filter-body">
                    <table class="table table-list-search" id="default">
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
                                <td>{{$result->task_no}}</td>
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
</div>
@endif
@endsection
