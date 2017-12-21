<div id="reset-password" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="reset-form" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" 
                            class="close" 
                            data-dismiss="modal" 
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Reset Password of <strong><span id="username"></span></strong>?</h4>
                </div>
            
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="userid">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="rpassword" name="password" class="form-control" required>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div> 
                   <div class="form-group">
                        <label for="password">Confirm Password</label>
                       <input type="password" id="c-password" name="password_confirmation" class="form-control" required>
                       @if ($errors->has('password_confirmation'))
                       <span class="help-block">
                           <strong>{{ $errors->first('password_confirmation') }}</strong>
                       </span>
                       @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" value="submit" class="btn btn-warning">
                        <i class="fa fa-fw fa-spinner fa-spin hidden"></i> Confirm
                    </button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
