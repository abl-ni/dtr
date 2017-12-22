<div id="addProject-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" 
                        class="close" 
                        data-dismiss="modal" 
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add Project</h4>
            </div>
            <form id="addProject-form">
               {{ csrf_field() }}
               <div class="modal-body">
                    <div class="form-group">
                        <label>Project Name</label>
                        <input  type="text" 
                                class="form-control" 
                                name="projectname"
                                required>
                    </div>
                    <div class="form-group">
                        <label>Project Manager</label>
                        <select name="pm" 
                                id="pm" 
                                class="form-control pm selectpicker" 
                                data-live-search="true">
                           @foreach ($pm as $pm)
                            <option id="{{ $pm->id }}" value="{{ $pm->id }}">
                                    {{ ucwords(htmlentities($pm->name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Team Leader</label>
                        <select name="tl" 
                                id="tl" 
                                class="form-control tl selectpicker" 
                                data-live-search="true">
                            @foreach ($dev as $dev)
                            <option  id="{{ $dev->id }}" value="{{ $dev->id }}">
                                    {{ ucwords(htmlentities($dev->name)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
               </div>
               <div class="modal-footer">
                   <button type="button" 
                           class="btn btn-default" 
                           data-dismiss="modal">
                           Cancel
                   </button>
                   <button  type="submit"
                            value="submit"
                            class="btn btn-warning">
                            <i class="fa fa-fw fa-spinner fa-spin hidden"></i> Add
                   </button>
               </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
