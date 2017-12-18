@extends('layouts.app')

@section('content')

@include('modals.create')
@include('modals.update')
@include('modals.delete')
@include('modals.dev')
@include('modals.confirmRemove')

@if(Auth::user()->type == 'Admin') 
    <!-- Sidebar -->
    @section('sidebar_menu')
    <li class="active">
        <a href="{{ url('dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="">
        <a href="{{ url('reports') }}">
            <i class="fa fa-files-o"></i> <span>Report</span>
        </a>
    </li>
    <li class="">
        <a href="{{ url('users') }}">
            <i class="fa fa-users"></i> <span>User</span>
        </a>
    </li>
    @endsection
    <!-- End Sidebar -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Projects
        <small>Data Table</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <div class="row">
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ $projectCount }}</h3>

              <p>Total Projects</p>
            </div>
            <div class="icon">
              <i class="ion ion-arrow-graph-up-right"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $today }}</h3>

              <p>Logs Today</p>
            </div>
            <div class="icon">
              <i class="ion ion-calendar"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>   
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-warning">
            <div class="box-header with-border">
                <button type="button" 
                        class="btn btn-primary btn-sm" 
                        data-toggle="modal" 
                        data-target="#addProject-modal">Add Project</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @include('inc.projects')                
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
@elseif (Auth::user()->type == 'PM')
    <!-- Sidebar -->
    @section('sidebar_menu')
    <li class="active">
        <a href="{{ url('dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="">
        <a href="{{ url('reports') }}">
            <i class="fa fa-files-o"></i> <span>Report</span>
        </a>
    </li>
    @endsection
    <!-- End Sidebar -->

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Projects
        <small>Data Table</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-warning">
            @include('inc.errors')
            @include('inc.success')
            <div class="box-header with-border">
                <button type="button" 
                        class="btn btn-primary btn-sm" 
                        data-toggle="modal" 
                        data-target="#addProject-modal">Add Project</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                @include('inc.projects')
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

@elseif (Auth::user()->type == 'Dev')
    @section('sidebar_menu')
    <li class="active">
        <a href="{{ url('dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="">
        <a href="{{ url('reports') }}">
            <i class="fa fa-files-o"></i> <span>Report</span>
        </a>
    </li>
    @endsection

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daily Log
        <small>Form</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
            @include('inc.form')
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

@endif

@endsection