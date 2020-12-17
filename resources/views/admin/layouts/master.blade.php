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
        <title>@yield('title') | {{$setting->translate('ar')->name}} </title>

        <!-- Fave Icons
        ================================-->
        <link rel="shortcut icon" href="{{$setting->icon}}">

        <!-- Google Web Fonts
        ===========================-->
        <link href="https://fonts.googleapis.com/earlyaccess/droidarabickufi.css" rel="stylesheet" type="text/css">

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
        <link rel="stylesheet" href="{{asset('assets/admin/css/loader.css')}}">
    </head>
    <body onload="loaderFunction()">
    <div id="loader"></div>
        <div id="wrapper">
            <div class="modal fade" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content text-center">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">هل تريد تأكيد الحذف ؟</h5>
                        </div>
                        <form class="modal-footer text-center">
                            <a type="button" class="custom-btn modalDLTBTN">مسح</a>
                            <a type="button" class="custom-btn red-bc" data-dismiss="modal">اغلاق</a>
                        </form>
                    </div>
                </div>
            </div>
            @yield('models')
            <div class="main">

                <!-- SIDEBAR -->
                @include('admin.layouts.sidebar')
                <div class="page-content">

                    <!-- HEADER -->
                    @include('admin.layouts.header')

                    <!-- CONTENT -->
                    @yield('content')
                </div><!--End Page-Content-->
            </div><!--End Main-->
        </div><!--End wrapper-->

        <!-- JS Base And Vendor
        ===================================-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="{{asset('assets/admin/js/jquery.form.js')}}"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.15/datatables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="{{asset('assets/admin/vendor/datatables.min.js')}}"></script>
        <script src="{{asset('assets/admin/vendor/count-to/jquery.countTo.js')}}"></script>

        <!--JS Main
        ====================================-->
    <script src="{{asset('assets/admin/js/loader.js')}}"></script>
    <script src="{{asset('assets/admin/js/main.js')}}"></script>
        <script src="{{asset('assets/admin/js/admin.js')}}"></script>

        @yield('js')
    </body>
</html>
