<div id="add-project" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Project</h4>
            </div>
           <form method="post">
               <div class="modal-body">
                    <div class="form-group">
                        <label>Project Name</label>
                        <input type="text" class="form-control" id="projectname-input">
                        <input type="hidden" class="current_user" id="{{ Auth::id() }}">
                    </div>
                    <div class="form-group">
                        <label>Project Manager</label>
                        <select name="pm" id="pm" class="form-control pm selectpicker" data-live-search="true">
                           @foreach ($pm as $pm)
                            <option id="{{ $pm->id }}" value="{{ $pm->name }}">{{ $pm->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Team Leader</label>
                        <select name="tl" id="tl" class="form-control tl selectpicker" data-live-search="true">
                            @foreach ($dev as $dev)
                            <option  id="{{ $dev->id }}" value="{{ $dev->name }}">{{ $dev->name }}</option>
                            @endforeach
                        </select>
                    </div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                   <button type="button" class="btn btn-primary" id="projectname-add"  data-dismiss="modal">Add</button>
               </div>
           </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{ csrf_field() }}