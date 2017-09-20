<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1 class="title text-center">Daily Task Report</h1> 
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="form-group">
                                <label for="project-name">Project Name</label>
                                <select class="form-control" id="project-name">
                                    <option>Choose</option>
                                    <option>Sample 1</option>
                                    <option>Sample 2</option>
                                    <option>Sample 3</option>
                                    <option>Sample 4</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="ticket-number">Ticket #</label>
                                <input class="form-control" type="text" id="ticket-number">
                            </div>
                            <div class="form-group">
                                <label for="task-title">Task Title</label>
                                <input class="form-control" type="text" id="task-title">
                            </div>
                            <div class="form-group">
                                <label for="roadblock">Roadblock</label>
                                <textarea class="form-control" type="text" id="roadblock" row="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="hours-rendered">Hours Rendered</label>
                                <input class="form-control" type="text" id="hours-rendered">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-submit col-md-12">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>