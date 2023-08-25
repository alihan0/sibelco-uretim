<!doctype html>
<html lang="tr">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title') - {{env('APP_NAME')}}</title>
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
        <link href="/static/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="/static/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="/static/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
        @yield('style')
    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">

            @include('src.topbar')

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    @if (Session::get('screen') == "admin")
                        @include('src.sidebar')
                    @elseif(Session::get('screen') == "staff")
                        @include('src.sidebar-staff')
                    @endif
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        @yield('content')
                        <!-- end page title -->

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                @include('src.footer')
                
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        

        <!-- Modal -->
        <div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="changePasswordLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="changePasswordLabel">Şifreni Değiştir</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label">Yeni Şifre:</label>
                        <div class="col-md-6">
                            <input class="form-control" type="password" placeholder="Yeni şifreni gir" id="newuserpassword">
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">vazgeç</button>
                <button type="button" class="btn btn-primary" onclick="changeUserPassword({{Auth::user()->id}})">Kaydet</button>
                </div>
            </div>
            </div>
        </div>

        <div class="modal fade" id="setDefaultScreen" tabindex="-1" aria-labelledby="setDefaultScreenLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="setDefaultScreenLabel">Varsayılan Görünüm Tercihleri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    
                    <p class="text-muted border-bottom mb-4 pb-4">
                        <b>Varsayılan Görünüm Tercihi</b> oturum açıldıktan sonra sistemin hangi ekranda başlatılacağını belirler. Başlatmak için <code>Yönetici Ekranı</code> ve <code>Kullanıcı Ekranı</code> olarak iki seçeneğiniz vardır. Bu ayarı değiştirebilmek için yetkiye sahip olmalısınız.
                    </p>
                    @if(Auth::user()->type == "ADMIN")
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label">Varsayılan Ekranı:</label>
                        <div class="col-md-6">
                            <select class="form-control" id="">
                                <option value="admin">Yönetici Görünümü</option>
                            </select>
                        </div>
                    </div>
                    <div class="alert alert-warning" role="alert">
                        Sadece <code>Yönetici Görünümü</code>'nü kullanmanıza izin veriliyor.
                      </div>
                    @elseif(Auth::user()->type == "USER")
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label">Varsayılan Ekranı:</label>
                        <div class="col-md-6">
                            <select class="form-control" id="">
                                <option value="staff">Kullanıcı Görünümü</option>
                            </select>
                        </div>
                    </div>
                    <div class="alert alert-warning" role="alert">
                        Sadece <code>Kullanıcı Görünümü</code>'nü kullanmanıza izin veriliyor.
                    </div>
                    @elseif(Auth::user()->type == "BOTH")
                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label">Varsayılan Ekranı:</label>
                        <div class="col-md-8">
                            <select class="form-control " id="setDefaultScreenSelect" data-user="{{Auth::user()->id}}">
                                <option value="admin" {{Auth::user()->default_screen == "admin" ? "selected" : ""}}>Yönetici Görünümü</option>
                                <option value="staff" {{Auth::user()->default_screen == "staff" ? "selected" : ""}}>Kullanıcı Görünümü</option>
                            </select>
                        </div>
                    </div>

                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="setDefaultScreenButton">Kaydet</button>
                </div>
            </div>
            </div>
        </div>

        <!-- JAVASCRIPT -->
        <script src="/static/assets/libs/jquery/jquery.min.js"></script>
        <script src="/static/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="/static/assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="/static/assets/libs/simplebar/simplebar.min.js"></script>
        <script src="/static/assets/libs/node-waves/waves.min.js"></script>

        <script src="/static/assets/js/app.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
        <script src="/static/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="/static/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="/static/assets/js/pages/datatables.init.js"></script>
        <script src="/static/assets/libs/sweetalert2/sweetalert2.min.js"></script>

        @yield('script')
        <script>
            $("#setDefaultScreenButton").on("click", function(){
                var screen = $("#setDefaultScreenSelect").val();
                var user = $("#setDefaultScreenSelect").attr('data-user');
                axios.post("/set-defatult-screen", {user:user, screen:screen}).then((res)=>{
                    if(res.data.status){
                        window.location.reload();
                    }
                });
            });


            $(".notification-item").on("click", function(){
                var id = $(this).attr("id");
                axios.post('/read-notification', {id:id}).then((res) => {
                    if(res.data.status){
                        window.location.reload();
                    }
                });
            });

            function changeUserPassword(userid){
                var password = $("#newuserpassword").val();

                axios.post('/change-password', {id:userid, password:password}).then((res)=>{
                    if(res.data.status){
                        window.location.assign('/auth/logout');
                    }
                });
            }

            $("#screenSwitcher").on("change", function(){
                var screen = $(this).val();
                
                axios.post('/switch-screen', {screen:screen}).then((res) => {
                    console.log(res)
                    if(res.data.status){
                        window.location.assign('/');
                    }
                })
            });

            
        </script>
    </body>
</html>
