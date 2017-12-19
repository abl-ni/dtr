@extends('layouts.app')

@section('title')
Report
@endsection

@section('content')
    <!-- Sidebar -->
    @section('sidebar_menu')
    <li class="">
        <a href="{{ url('dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="active">
        <a href="{{ url('reports') }}">
            <i class="fa fa-files-o"></i> <span>Report</span>
        </a>
    </li>
    @if(Auth::user()->type == 'Admin')
    <li class="">
        <a href="{{ url('users') }}">
            <i class="fa fa-users"></i> <span>User</span>
        </a>
    </li>
    @endif
    @endsection
    <!-- End Sidebar -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reports
        <small>Data Table</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>


    <!-- Main content -->
    <section class="content">
    @if($result->isNotEmpty())
        <div class="row">
            <div class="col-md-3">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Graph Report</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
    @else
        <div class="row">
    @endif
            <div class="col-md-9">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <form method="post">
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <select id="groupBy" class="form-control">
                                            @if(Auth::user()->type !== 'Dev')
                                            <option data-group="developer" data-icon="icon icon-user"> Group by Developers</option>
                                            @endif
                                            <option data-group="project" data-icon="icon icon-folder"> Group by Projects</option>
                                            <option data-group="ticket" data-icon="icon icon-film"> Group by Tickets</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <div id="reportrange" class="form-control">
                                            <i class="icon icon-calendar"></i>&nbsp;
                                            <span></span> <b class="caret"></b>
                                            <input type="hidden" id="start">
                                            <input type="hidden" id="end">
                                        </div>  
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default form-control" id="filterGo-btn">Go</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="report-list" class="table table-bordered table-hover dataTable" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-2">Name</th>
                                    <th class="col-md-2">Project Name</th>
                                    <th class="col-md-1">Ticket #</th>
                                    <th class="col-md-2">Task Title</th>
                                    <th class="col-md-2">Roadblock</th>
                                    <th class="col-md-1">Date</th>
                                    <th class="col-md-1">Hours</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-2">Name</th>
                                    <th class="col-md-2">Project Name</th>
                                    <th class="col-md-1">Ticket #</th>
                                    <th class="col-md-2">Task Title</th>
                                    <th class="col-md-2">Roadblock</th>
                                    <th class="col-md-1">Date</th>
                                    <th class="col-md-1">Hours</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
