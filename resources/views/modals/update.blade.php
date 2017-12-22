<div id="updateProject-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update Project</h4>
            </div>
            <form id="updateProject-form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <label>Project Name</label>
                        <input name="projectname" type="text" class="form-control" id="projectname-updated">
                        <input name="projectid" type="hidden" id="id">
                        <label>Project Manager</label>
                        <select name="pm" id="pm_list" class="form-control pm selectpicker" data-live-search="true">
                            @foreach ($allPM as $all)
                            <option id="{{ $all->id }}" value="{{ $all->id }}">{{ ucwords(htmlentities($all->name)) }}</option>
                            @endforeach
                        </select>
                        <label>Team Leader</label>
                        <select name="dev" id="dev_list" class="form-control dev selectpicker" data-live-search="true">
                            @foreach ($dev as $dev)
                            <option id="{{ $dev->id }}" value="{{ $dev->id }}">{{ ucwords(htmlentities($dev->name)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" value="submit" class="btn btn-warning" id="project-update">
                        <i class="fa fa-fw fa-spinner fa-spin hidden"></i> Save Changes
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
