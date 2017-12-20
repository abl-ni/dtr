<div id="confirmRemove-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Remove Developer</h4>
            </div>
            <form id="removeUser-form" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="projectid">
                <div class="modal-body">
                    <div class="form-group">
                        Are you sure you want to delete <strong> <span id="username" class="text-danger"></span></strong> in  <strong> <span id="projectname" class="text-uppercase"></span></strong> project? 
                        <input type="hidden" name="userid" id="userid">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" value="submit" class="btn btn-danger">Yes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
