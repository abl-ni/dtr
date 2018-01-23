<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<?php
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
    <!-- Styles -->
    @if (App::isLocal())
      <link href="{{ asset('images/bywave_icon.ico') }}" rel="shortcut icon"/>
      <link href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"/>
      <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"/>
      <link href="{{ asset('vendor/Ionicons/css/ionicons.min.css') }}" rel="stylesheet"/>
      <link href="{{ asset('vendor/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet"/>
      <link href="{{ asset('vendor/pnotify/pnotify.custom.min.css') }}" media="all" rel="stylesheet" type="text/css" />
      <link href="{{ asset('vendor/dist/css/AdminLTE.min.css') }}" rel="stylesheet"/>
      <link href="{{ asset('vendor/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet"/>
    @else
      @if (Request::server('HTTP_X_FORWARDED_PROTO') == 'http')
      <link href="{{ asset('images/bywave_icon.ico') }}" rel="shortcut icon"/>
      <link href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"/>
      <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"/>
      <link href="{{ asset('vendor/Ionicons/css/ionicons.min.css') }}" rel="stylesheet"/>
      <link href="{{ asset('vendor/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet"/>
      <link href="{{ asset('vendor/pnotify/pnotify.custom.min.css') }}" media="all" rel="stylesheet" type="text/css" />
      <link href="{{ asset('vendor/dist/css/AdminLTE.min.css') }}" rel="stylesheet"/>
      <link href="{{ asset('vendor/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet"/>
      @else
      <link href="{{ secure_asset('images/bywave_icon.ico') }}" rel="shortcut icon"/>
      <link href="{{ secure_asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"/>
      <link href="{{ secure_asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"/>
      <link href="{{ secure_asset('vendor/Ionicons/css/ionicons.min.css') }}" rel="stylesheet"/>
      <link href="{{ secure_asset('vendor/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet"/>
      <link href="{{ secure_asset('pnotify/pnotify.custom.min.css') }}" media="all" rel="stylesheet" type="text/css" />
      <link href="{{ secure_asset('vendor/dist/css/AdminLTE.min.css') }}" rel="stylesheet"/>
      <link href="{{ secure_asset('vendor/dist/css/skins/_all-skins.min.css') }}" rel="stylesheet"/>
      @endif
    @endif

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowgroup/1.0.2/css/rowGroup.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" />

</head>
<body class="hold-transition skin-yellow sidebar-collapse sidebar-mini">
    <div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="@guest {{url('/')}} @else {{url('/dashboard ')}} @endguest" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>T</b>W</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">{{ config('app.name')}}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-success">{{ count($notifications) }}</span>
            </a>
            <ul class="dropdown-menu list-group">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @foreach ($notifications as $notification)
                    <!-- start message -->
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <img src="{{ asset('vendor/dist/img/avatar5.png')}}" class="img-circle" alt="User Image">
                        </div>
                        <h4>
                          {{ ucwords($notification->requested_by()->pluck('name')[0]) }}
                          <small><i class="fa fa-clock-o"></i> 5 mins</small>
                        </h4>
                        <p>{{$notification->message}}</p>
                        <div class="pull-right">
                          <span class="btn btn-success btn-xs">Accept</span>
                          <span class="btn btn-danger btn-xs">Cancel</span>
                        </div>
                      </a>
                    </li>
                    <!-- end message -->
                  @endforeach
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{ asset('vendor/dist/img/avatar5.png')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">
                @if(Auth::user()->name)
                  {{ ucwords(Auth::user()->name) }}
                @endif
              </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{ asset('vendor/dist/img/avatar5.png')}}" class="img-circle" alt="User Image">

                <p>
                  @if(Auth::user()->name)
                    {{ ucwords(Auth::user()->name) }}
                  @endif
                  <small>@if(Auth::user()->type) {{ Auth::user()->type }} @endif</small>
                </p>
              </li>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">                  
                    <a class="btn btn-default" href="{{ url('profile') }}">
                        Profile
                    </a>
                </div>
                <div class="pull-right">                  
                    <button class="btn btn-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        Sign out
                    </button>
                    <form id="logout-form" 
                          action="{{ route('logout') }}" 
                          method="GET" 
                          style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
    <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('vendor/dist/img/avatar5.png')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
         <p>
                  @if(Auth::user()->name)
                    {{ ucwords(Auth::user()->name) }}
                  @endif
                 
                </p>
                 <small>@if(Auth::user()->type) {{ Auth::user()->type }} @endif</small>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        @yield('sidebar_menu');
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>          
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
        @yield('content')
        </div>
        <footer class="main-footer">
          <div class="pull-right hidden-xs">
           <p style="font-size: 10px;">Version 2.4.0</p> 
          </div>
          <strong style="font-size: 10px;">Copyright © 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>. All rights
          reserved.</strong> 
        </footer>
    </div>

    <!-- Scripts -->

    <!-- Socket IO -->
    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>

    @if (App::isLocal())      
      <!-- App JS -->
      <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
      <!-- DataTables -->
      <script type="text/javascript" src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('vendor/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
      <!-- SlimScroll -->
      <script type="text/javascript" src="{{ asset('vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
      <!-- FastClick -->
      <script type="text/javascript" src="{{ asset('vendor/fastclick/lib/fastclick.js')}}"></script>
      <!-- PNotify -->
      <script type="text/javascript" src="{{ asset('vendor/pnotify/pnotify.custom.min.js')}} "></script>
      <!-- AdminLTE App -->
      <script type="text/javascript" src="{{ asset('vendor/dist/js/adminlte.min.js')}}"></script>
      <!-- Custom JS -->
      <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
    @else
      @if (Request::server('HTTP_X_FORWARDED_PROTO') == 'http')
      <!-- App JS -->
      <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
      <!-- DataTables -->
      <script type="text/javascript" src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
      <script type="text/javascript" src="{{ asset('vendor/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
      <!-- SlimScroll -->
      <script type="text/javascript" src="{{ asset('vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
      <!-- FastClick -->
      <script type="text/javascript" src="{{ asset('vendor/fastclick/lib/fastclick.js')}}"></script>
      <!-- PNotify -->
      <script type="text/javascript" src="{{ asset('vendor/pnotify/pnotify.custom.min.js')}} "></script>
      <!-- AdminLTE App -->
      <script type="text/javascript" src="{{ asset('vendor/dist/js/adminlte.min.js')}}"></script>
      <!-- Custom JS -->
      <script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
      @else
      <!-- App JS -->
      <script type="text/javascript" src="{{ secure_asset('js/app.js') }}"></script>
      <!-- DataTables -->
      <script type="text/javascript" src="{{ secure_asset('vendor/datatables.net/js/jquery.dataTables.min.js')}}"></script>
      <script type="text/javascript" src="{{ secure_asset('vendor/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
      <!-- SlimScroll -->
      <script type="text/javascript" src="{{ secure_asset('vendor/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
      <!-- FastClick -->
      <script type="text/javascript" src="{{ secure_asset('vendor/fastclick/lib/fastclick.js')}}"></script>
      <!-- PNotify -->
      <script type="text/javascript" src="{{ secure_asset('pnotify/pnotify.custom.min.js')}} "></script>
      <!-- AdminLTE App -->
      <script type="text/javascript" src="{{ secure_asset('vendor/dist/js/adminlte.min.js')}}"></script>
      <!-- Custom JS -->
      <script type="text/javascript" src="{{ secure_asset('js/custom.js') }}"></script>
      @endif
    @endif

    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.0.2/js/dataTables.rowGroup.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script type="text/javascript">
      if(document.getElementById('report-list'))
      $.fn.dataTableExt.afnFiltering.push(
          function( oSettings, aData, iDataIndex ) {
              var iFini = $('#start').val();
              var iFfin = $('#end').val();
              var iStartDateCol = 6;
              var iEndDateCol = 6;
       
              iFini=iFini.substring(0,4) + iFini.substring(5,7)+ iFini.substring(8,10);
              iFfin=iFfin.substring(0,4) + iFfin.substring(5,7)+ iFfin.substring(8,10);
       
              var datofini=aData[iStartDateCol].substring(0,4) + aData[iStartDateCol].substring(5,7)+ aData[iStartDateCol].substring(8,10);
              var datoffin=aData[iEndDateCol].substring(0,4) + aData[iEndDateCol].substring(5,7)+ aData[iEndDateCol].substring(8,10);

              if ( iFini === "" && iFfin === "" )
              {
                  return true;
              }
              else if ( iFini <= datofini && iFfin === "")
              {
                  return true;
              }
              else if ( iFfin >= datoffin && iFini === "")
              {
                  return true;
              }
              else if (iFini <= datofini && iFfin >= datoffin)
              {
                  return true;
              }
              return false;
          }
      );
    </script>
</body>
</html>
