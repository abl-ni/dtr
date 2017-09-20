<div id="update-project" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Update Project</h4>
            </div>
            <form action="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Project Name</label>
                        <input type="text" class="form-control" id="projectname-updated">
                        <input type="hidden" id="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="projectname-update"  data-dismiss="modal">Save Changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{ csrf_field() }}