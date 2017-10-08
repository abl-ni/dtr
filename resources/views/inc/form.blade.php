<div class="container">
    <div class="row">
        <div class="form-container col-md-8 col-md-offset-2">
            @include('inc.errors')
            @include('inc.success')
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="title text-center">Daily Task Report</h3> 
                </div>

                <div class="panel-body">
                    <form method="post" action="addLogs">
                        {{ csrf_field() }}
                        <div class="col-md-10 col-md-offset-1">
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
                                            {{ $project->name }}
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
                                    <textarea name="roadblock" class="form-control" type="text" row="3">
                                    </textarea>
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
                                        3:30 = 3 hours and 30 minutes = 
                                        <span class="text-danger"><b>3.30</b></span>
                                        <br>
                                    </span>
                                </div>
                            </div>
                            <br><br><br>
                            <div class="form-group">
                                <button value="submit" 
                                        type="submit" 
                                        class="btn btn-primary btn-submit col-md-12">
                                    Submit
                                </button>
                            </div>
                            <br><br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

