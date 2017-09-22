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
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">View by</h3>
                    </div>
                    <div class="panel-body">
                        <form action="">
                            <div class="form-group">
                                <select class="form-control" name="" id="">
                                    <option value="">Project</option>
                                    <option value="">Project Manager</option>
                                    <option value="">Developer</option>
                                </select>
                            </div>
                            <div class="form-group"> 
                                <input id="text" class="form-control">
                            </div>
                            <div class="form-group"> 
                                <button type="submit" class="btn btn-default col-lg-12">
                                    Go
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 tab-content">
            <div class="col-lg-12 tab-pane active" id="project-tab">
                @include('inc.projects')
            </div>
            <div class="col-lg-12 tab-pane" id="reports-tab">
                @include('inc.reports')
            </div>
        </div>
    </div>
</div>
    @endif
@endsection

