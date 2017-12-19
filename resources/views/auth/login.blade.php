<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} | Log In</title>

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        
        <!-- Styles -->        
        @if (App::isLocal())
            <link href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"/>
            <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"/>
            <link href="{{ asset('vendor/Ionicons/css/ionicons.min.css') }}" rel="stylesheet"/>
            <link href="{{ asset('vendor/dist/css/AdminLTE.min.css') }}" rel="stylesheet"/>
            <link href="{{ asset('vendor/plugins/iCheck/square/blue.css') }}" rel="stylesheet"/>
        @else
            @if (Request::server('HTTP_X_FORWARDED_PROTO') == 'http')
            <link href="{{ asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"/>
            <link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"/>
            <link href="{{ asset('vendor/Ionicons/css/ionicons.min.css') }}" rel="stylesheet"/>
            <link href="{{ asset('vendor/dist/css/AdminLTE.min.css') }}" rel="stylesheet"/>
            <link href="{{ asset('vendor/plugins/iCheck/square/blue.css') }}" rel="stylesheet"/>
            @else
            <link href="{{ secure_asset('vendor/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"/>
            <link href="{{ secure_asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"/>
            <link href="{{ secure_asset('vendor/Ionicons/css/ionicons.min.css') }}" rel="stylesheet"/>
            <link href="{{ secure_asset('vendor/dist/css/AdminLTE.min.css') }}" rel="stylesheet"/>
            <link href="{{ secure_asset('vendor/plugins/iCheck/square/blue.css') }}" rel="stylesheet"/>
            @endif
        @endif

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="../../index2.html"><b>Time</b>wave</a>
            </div>

            <div class="login-box-body">
                <div class="col-md-12">
                    <img class="col-xs-12" src="{{asset('images/bywave_logo.png')}}">
                </div>
                <p class="login-box-msg">Sign in</p>

                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        
                        @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                        </div>
                    <!-- /.col -->
                    </div>
                </form>
            </div>
        </div>
        <!-- /.login-box -->

        @if (App::isLocal())
        <!-- jQuery 3 -->
        <script src="{{ asset('vendor/jquery/dist/jquery.min.js')}}"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <!-- iCheck -->
        <script src="{{ asset('vendor/plugins/iCheck/icheck.min.js')}}"></script>
        @else
            @if (Request::server('HTTP_X_FORWARDED_PROTO') == 'http')
                <!-- jQuery 3 -->
                <script src="{{ asset('vendor/jquery/dist/jquery.min.js')}}"></script>
                <!-- Bootstrap 3.3.7 -->
                <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
                <!-- iCheck -->
                <script src="{{ asset('vendor/plugins/iCheck/icheck.min.js')}}"></script>
            @else
                <!-- jQuery 3 -->
                <script src="{{ secure_asset('vendor/jquery/dist/jquery.min.js')}}"></script>
                <!-- Bootstrap 3.3.7 -->
                <script src="{{ secure_asset('vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
                <!-- iCheck -->
                <script src="{{ secure_asset('vendor/plugins/iCheck/icheck.min.js')}}"></script>
            @endif
        @endif
        <script>
          $(function () {
            $('input').iCheck({
              checkboxClass: 'icheckbox_square-blue',
              radioClass: 'iradio_square-blue',
              increaseArea: '20%' // optional
            });
          });
        </script>
    </body>
</html>