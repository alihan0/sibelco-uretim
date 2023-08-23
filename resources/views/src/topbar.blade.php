<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="/static/assets/images/logo-sm-dark.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="/static/assets/images/logo-dark.png" alt="" height="20">
                    </span>
                </a>

                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="/static/assets/images/logo-sm-light.png" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="/static/assets/images/logo-light.png" alt="" height="20">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="mdi mdi-backburger"></i>
            </button>
        </div>

        <div class="d-flex">

            

            

            <div class="dropdown d-none d-lg-inline-block ml-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>


            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-bell-outline"></i>
                    @if ($notifications->count() > 0)
                    <span class="badge badge-danger badge-pill">{{$notifications->count()}}</span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0 font-weight-medium text-uppercase"> Bildirimler </h6>
                            </div>
                            <div class="col-auto">
                                <span class="badge badge-pill badge-danger">{{$notifications->count()}}</span>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                    
                        @foreach ($notifications as $notification)
                        <a href="javascript:;" class="text-reset notification-item" id="{{$notification->id}}">
                            <div class="media">
                                
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">{{$notification->title}}</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">{{$notification->message}}</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline"></i> {{date("d M, Y", strtotime($notification->created_at))}}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="/static/assets/images/user.png"
                        alt="Header Avatar">
                    <span class="d-none d-sm-inline-block ml-1">{{Auth::user()->name}}</span>
                    <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/auth/logout"><i class="mdi mdi-logout font-size-16 align-middle mr-1"></i> Çıkış Yap</a>
                </div>
            </div>

        </div>
    </div>
</header>