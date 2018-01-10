<div class="col-md-10 col-md-offset-1">
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Daily Task Report</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="add-log" method="post">
            <div class="box-body">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="col-md-3">
                        <label for="project-name">Project Name</label>
                    </div>
                    <div class="col-md-9">
                        <select class="selectpicker form-control"
                                name="projectid" 
                                id="selectProject" 
                                data-live-search="true">
                            @foreach($project as $project)
                            <option id="{{ $project->id }}" value="{{ $project->id }}">
                                {{ ucwords(htmlentities($project->name)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br><br>
                <div class="form-group">
                    <div class="col-md-3">
                        <label for="ticket-number">Ticket #</label>
                    </div>
                    <div class="col-md-9">
                        <input name="ticket_number" class="form-control" type="text" required>
                        <br>
                    </div>
                </div>
                <br><br>
                <div class="form-group">
                    <div class="col-md-3">
                        <label for="task-title">Task Title</label>
                    </div>
                    <div class="col-md-9">
                        <input name="task_title"  class="form-control" type="text" required>
                    </div>
                </div>
                <br><br>
                <div class="form-group">
                    <div class="col-md-3">
                        <label for="roadblock">Roadblock</label>
                    </div>
                    <div class="col-md-9">
                        <textarea name="roadblock" class="form-control" type="text" row="3"></textarea>
                    </div>
                </div>
                <br><br><br>
                <div class="form-group">
                    <div class="col-md-3">
                        <label for="hours-rendered">Hours Rendered</label>
                    </div>
                    <div class="col-md-9">
                        <input class="form-control" type="text" name="hrs_rendered" required>
                        <span class="" style="font-size:8pt; font-family: sans-serif">
                            <strong>Format: </strong>
                            3 hours and 30 minutes = 
                            <span class="text-danger"><b> 3.5</b></span>
                            <br>
                        </span>
                    </div>
                </div>
            </div>
                <!-- /.box-body -->

            <div class="box-footer">
                    <button value="submit" 
                            type="submit" 
                            class="btn btn-primary btn-submit col-md-12">
                        <i class="fa fa-fw fa-spinner fa-spin hidden"></i> Submit
                    </button>
            </div>
        </form>
    </div>
</div>