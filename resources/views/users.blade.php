@extends('layouts.app')

@section('content')
@include('modals.resetpassword')
@include('modals.resetrole')
<div class="row dash-nav">
    <div class="dash-navbar col-md-12">
        <ul class="nav nav-pills nav-justified">
            <li class="nav-item"><a class="nav-link" href="{{ url('dashboard') }}">Projects</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('reports') }}">Reports</a></li>
            <li class="nav-item active"><a class="nav-link" href="{{ url('users') }}">Users</a></li>
        </ul>
    </div>
</div>
<div class="dashboard-container">
    @include('inc.errors')
    @include('inc.success')
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-default">
                <div class="panel-body" id="filter-body">
                    <table id="user-list" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="col-md-1">ID</th>
                                <th class="col-md-1">Name</th>
                                <th class="col-md-1">Email</th>
                                <th class="col-md-1">Role</th>
                                <th class="col-md-1">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th class="col-md-1">ID</th>
                                <th class="col-md-1">Name</th>
                                <th class="col-md-1">Email</th>
                                <th class="col-md-1">Role</th>
                                <th class="col-md-1">Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
