@extends('layouts.app')
@section('title')
Profile
@endsection
@section('content')

@if(Auth::user()->type == 'Admin') 
    <!-- Sidebar -->
    @section('sidebar_menu')
    <li class="">
        <a href="{{ url('dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="">
        <a href="{{ url('reports') }}">
            <i class="fa fa-files-o"></i> <span>Report</span>
        </a>
    </li>
    <li class="">
        <a href="{{ url('users') }}">
            <i class="fa fa-users"></i> <span>User</span>
        </a>
    </li>
    @endsection
    <!-- End Sidebar -->
@elseif (Auth::user()->type == 'PM')
    <!-- Sidebar -->
    @section('sidebar_menu')
    <li class="">
        <a href="{{ url('dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="">
        <a href="{{ url('reports') }}">
            <i class="fa fa-files-o"></i> <span>Report</span>
        </a>
    </li>
    @endsection
    <!-- End Sidebar -->
@elseif (Auth::user()->type == 'Dev')
    <!-- Sidebar -->
    @section('sidebar_menu')
    <li class="">
        <a href="{{ url('dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
    </li>
    <li class="">
        <a href="{{ url('reports') }}">
            <i class="fa fa-files-o"></i> <span>Report</span>
        </a>
    </li>
    @endsection
    <!-- End Sidebar -->
@endif

    <!-- Content Header (Page header) -->
    <section class="content-header">      
      <h1>
        <i class="fa fa-user"></i> <span>Profile</span>         
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Profile</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-warning">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="{{ asset('vendor/dist/img/avatar5.png')}}" alt="User profile picture">
              <h3 class="profile-username text-center">
                  @if(Auth::user()->name)
                    {{ ucwords(Auth::user()->name) }}
                  @endif
              </h3>

              <p class="text-muted text-center">@if(Auth::user()->type) {{ Auth::user()->type }} @endif</p>

              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
           
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              
              <li><a href="#PI" data-toggle="tab">Personal Information</a></li>
            </ul>
            <div class="tab-content" >
               
             

              <div class="active tab-pane" id="PI">
                <form class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputName" placeholder="Name" value=" @if(Auth::user()->name)
                    {{ ucwords(Auth::user()->name) }} 
                  @endif" readonly="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="inputEmail" placeholder="Email" value=" @if(Auth::user()->name)
                    {{ ucwords(Auth::user()->email) }} 
                  @endif" readonly="">
                    </div>
                  </div>
                </form>

              </div>
              <!-- /.tab-pane -->
              

            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
         <div class="form-group">
                    

                    <div class="col-sm-10">
                     <button class="btn btn-info" id="changePassword">Change Password</button>
                    </div>
                  </div>
        <!-- /.col -->

      <!-- /.row -->

    </section>
    <!-- /.content -->
   <div id="change-password" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="changePasswordForm" method="post">
                {{ csrf_field() }}
                <div class="modal-header">
                    <button type="button" 
                            class="close" 
                            data-dismiss="modal" 
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Reset Password </h4>
                </div>
            
                <input type="hidden" name="_method" value="put">
                <input type="hidden" name="OpasswordCheck" value=" @if(Auth::user()->name)
                    {{ ucwords(Auth::user()->password) }} 
                  @endif">
                <input type="hidden" name="userid" value=" @if(Auth::user()->name)
                    {{ ucwords(Auth::user()->id) }} 
                  @endif">
                <div class="modal-body">
                   <div class="form-group">
                        <label for="password">Current Password</label>
                        <input type="password" id="Opassword" name="Opassword" class="form-control" required>
                        
                    </div> 
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" id="Npassword" name="Npassword" class="form-control" required>
                        @if ($errors->has('Npassword'))
                        <span class="help-block">
                            <strong>{{ $errors->first('Npassword') }}</strong>
                        </span>
                        @endif
                    </div> 
                   <div class="form-group">
                        <label for="password">Confirm New Password</label>
                       <input type="password" id="Npassword_confirmation" name="Npassword_confirmation" class="form-control" required>
                       @if ($errors->has('Npassword_confirmation'))
                       <span class="help-block">
                           <strong>{{ $errors->first('Npassword_confirmation') }}</strong>
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
        </div>
     </div> 
</div> 
  

@endsection