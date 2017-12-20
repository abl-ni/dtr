<div id="reset-role" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="resetrole-form" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" 
                            class="close" 
                            data-dismiss="modal" 
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Change <strong><span id="username"></span></strong> role type?</h4>
                </div>

                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="userid" value="put">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password">Select Role:</label>
                        <select name="updatedRole" class="form-control">
                            <option value="Dev">Dev</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" value="submit" class="btn btn-warning">Save Changes</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
