<div id="delete-project" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Delete Project</h4>
            </div>
            <form action="post">
                <div class="modal-body">
                    <div class="form-group">
                        Are you Sure you want to delete <strong> <span id="projectname" class="text-uppercase"></span></strong> ? 
                        <span class="hidden" id="projectid"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="project-delete"  data-dismiss="modal">Yes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{ csrf_field() }}