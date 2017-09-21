<div class="panel panel-default">
    <div class="panel-heading">
        <span class="panel-title font-weight-bold">Projects</span>
        <button type="button" class="btn btn-primary btn-sm pull-right" data-id="{{ Auth::user()->id }}" data-toggle="modal" data-target="#add-project">
            Add Project</button>
    </div>
    <div class="panel-body">
        <table class="table table-borderless table-responsive">
            <thead>
                <tr>
                    <th class="col-md-1">ID</th>
                    <th class="col-md-3">Name</th>
                    <th class="col-md-2">Developers</th>
                    <th class="col-md-2">Actions</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @foreach($data as $project)    
                <tr class="item{{$project->id}}">
                    <td>{{$project->id}}</td>
                    <td>{{$project->name}}</td>
                    <td><span class="badge">14</span></td>
                    <td>
                        <div class="col-sm-12">
                            <button class="edit-modal btn btn-warning btn-sm col-sm-5 col-sm-offset-1" data-id="{{$project->id}}" data-name="{{$project->name}}" data-target="#update-project">
                                Update
                            </button>
                            <button class="delete-modal btn btn-danger btn-sm col-sm-5 col-sm-offset-1" data-id="{{$project->id}}" data-name="{{$project->name}}" data-target="#delete-project">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach 
            </tbody>   
        </table>
    </div>
</div>
