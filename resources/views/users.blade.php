@extends('layouts.app')

@section('content')
@include('modals.resetpassword')
@include('modals.resetrole')
@include('modals.add_user')
    <!-- Sidebar -->
    @section('sidebar_menu')
    <li class="">
        <a href="{{ url('dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="">
        <a href="{{ url('reports') }}">
            <i class="fa fa-files-o"></i> <span>Report</span>
        </a>
    </li>
    @if(Auth::user()->type == 'Admin')
    <li class="active">
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
        User Accounts
        <small>Data Table</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        @include('inc.errors')
        @include('inc.success')
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <button type="button" 
                                class="btn btn-primary btn-sm" 
                                data-toggle="modal" 
                                data-target="#addUser-modal">Add User
                        </button>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="user-list" class="table table-bordered table-hover dataTable" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
