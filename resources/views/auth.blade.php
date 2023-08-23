<!doctype html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Oturum Aç - {{env('APP_NAME')}}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Metatige Dijital" name="author" />
        <meta content="0546 497 1229" name="contact" />
        <meta content="www.metatige.com" name="website" />
    
        <!-- App favicon -->
        <link rel="shortcut icon" href="/static/assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="/static/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="/static/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="/static/assets/css/app.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" />

    </head>

    <body class="bg-primary bg-pattern">
        

        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mb-5">
                            <a href="index.html" class="logo"><img src="/static/assets/images/logo-light.png" height="24" alt="logo"></a>
                            
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        @yield('content')
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
        <!-- end Account pages -->

        <!-- JAVASCRIPT -->
        <script src="/static/assets/libs/jquery/jquery.min.js"></script>
        <script src="/static/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/static/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="/static/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="/static/assets/libs/node-waves/waves.min.js"></script>

        <script src="/static/assets/js/app.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
        @yield('script')
    </body>
</html>
