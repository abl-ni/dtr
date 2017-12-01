<div id="add-dev" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Developers</h4>
            </div>
            <form action="/add_devs" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Added Developers</label>
                        <select id="select_devs" class="selectpicker form-control select_devs" multiple data-live-search="true">
                        </select>
                        <input type="hidden" id="project_id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning" id="add_devs_btn"  data-dismiss="modal">Save Changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{ csrf_field() }}