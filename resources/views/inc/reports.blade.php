<div class="container">
    <div class="row">
        <div class="col-md-4  col-md-offset-8">
            <form action="{{url('project')}}">
                <div class="form-group">
                    {{csrf_field()}}
                    <div class="col-md-9">
                        <input type="text" name="add-project" class="form-control"> 
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success" type="submit">Add</button> 
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Reports
                </div>

                <div class="panel-body">
                    <table class="table table-list-search">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Project Name</th>
                                <th>Ticket #</th>
                                <th>Task Title</th>
                                <th>Roadblock</th>
                                <th>Hours Rendered</th>
                            </tr>
                        </thead>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>