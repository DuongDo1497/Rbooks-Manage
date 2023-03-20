<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/square/blue.css') }}">

    <link rel="stylesheet" href="{{ asset('css/pages/login.css') }}">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('image/icon-login.png') }}" alt="">
            <h2>
                <a href="{{ route('dashboard') }}">
                    <b>{{ config('app.name') }}</b>
                </a>
            </h2>
        </div>
        
        <div class="login-box-body">
            <form action="{{ route('login') }}" method="post">
                {{ csrf_field() }}
                <div class="login-form">
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email" name="email" required="required" value="{{ env('TEST_USERNAME') }}">
                        <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
                        <span class="form-control-feedback">
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="password" required="required" value="{{ env('TEST_PASSWORD') }}">
                        <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
                        <span class="form-control-feedback">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
                <div class="login-control">
                    <div class="row">
                        <div class="col-xs-7">
                            <div class="checkbox icheck login-remember">
                                <input type="checkbox" name="remember" value="1">
                                <span class="text">Duy trì đăng nhập</span>
                            </div>
                        </div>
                        <div class="col-xs-5">
                            <a href="#" class="forgot-pass"><b>{{ trans('home.Quên mật khẩu') }}?</b></a>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-signin">{{ trans('home.Đăng nhập') }}</button>
            </form>
        </div>
    </div>

    
    <script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
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
