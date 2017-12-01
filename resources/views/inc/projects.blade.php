<div class="row dash-nav">
    <div class="dash-navbar col-md-12">
        <ul class="nav nav-pills nav-justified">
            <li class="nav-item active"><a class="nav-link" href="{{ url('dashboard') }}">Projects</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ url('reports') }}">Reports</a></li>
        </ul>
    </div>
</div>
<div class="dashboard-container">
    @include('inc.errors')
    @include('inc.success')
    <div class="row">
        <div class="col-lg-12">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span class="panel-title font-weight-bold">Projects</span>
                        <button type="button" 
                                class="btn btn-primary btn-sm pull-right" 
                                data-toggle="modal" 
                                data-target="#addProject-modal">Add Project</button>
                    </div>
                    <div class="panel-body col-lg-12 bg-white padding-none">
                        <table id="project-list" class="table table-borderless table-responsive">
                            <thead>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-3">Name</th>
                                    <th class="col-md-2">Project Manager</th>
                                    <th class="col-md-2">Team Leader</th>
                                    <th class="col-md-2">Developers</th>
                                    <th class="col-md-2">Actions</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-3">Name</th>
                                    <th class="col-md-2">Project Manager</th>
                                    <th class="col-md-2">Team Leader</th>
                                    <th class="col-md-2">Developers</th>
                                    <th class="col-md-2">Actions</th>
                                </tr>
                            </tfoot>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>