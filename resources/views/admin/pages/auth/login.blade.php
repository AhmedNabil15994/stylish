<!DOCTYPE html>
<html>
    <head>
        <!-- Meta Tags
        ======================-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="">

        <!-- Title Name
        ================================-->
        <title>{{$setting->name}}</title>

        <!-- Fave Icons
        ================================-->
        <link rel="shortcut icon" href="{{$setting->icon}}">

        <!-- Google Web Fonts
        ===========================-->
        <link href="http://fonts.googleapis.com/earlyaccess/droidarabickufi.css" rel="stylesheet" type="text/css">

        <!-- Css Base And Vendor
        ===================================-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{asset('assets/admin/vendor/bootstrap/bootstrap-ar.css')}}">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="all">
        <link rel="stylesheet" href="{{asset('assets/admin/vendor/animation/animate.css')}}">

        <!-- Site Css
        ====================================-->
        <link rel="stylesheet" href="{{asset('assets/admin/css/style.css')}}">
        <link rel="stylesheet" href="{{asset('assets/admin/css/theme/default-theme.css')}}">
    </head>
    <body>
        <div class="log-wrap">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="login-register">
                            <div class="logo"><img src="{{$setting->logo}}"></div>
                            <form class="login-form" action="{{ route('admin.login') }}" method="post">
                                {!! csrf_field()  !!}
                                <div class="alert alert-success hidden " id="headLogActionSuccess"></div>
                                <div class="alert alert-danger hidden " id="headLogActionError"></div>

                                <div class="form-group">
                                    <input type="text" placeholder="اسم المستخدم" name="email" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="password" placeholder="الرقم السري" name="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <div class="remember">
                                        <input name="remember" id="remember" type="checkbox">
                                        <label for="remember">تذكرني</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="custom-btn" type="submit">تسجيل الدخول</button>
                                </div>
                                <div class="spacer-15"></div>
                            </form>
                        </div>
                    </div>
                </div><!--End row-->
            </div>
        </div>
        <!-- JS Base And Vendor
         ===================================-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="{{asset('assets/admin/vendor/datatables.min.js')}}"></script>

        <!--JS Main
        ====================================-->
        <script src="{{asset('assets/admin/js/main.js')}}"></script>

        <!-- authentication validation -->
        <script src="{{asset('assets/admin/js/jquery.validate.js')}}" type="text/javascript"></script>
        <script src="{{asset('assets/admin/js/login.js')}}" type="text/javascript"></script>
    </body>
</html>
