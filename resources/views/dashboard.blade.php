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

