@extends('auth')

@section('content')
    <div class="card">
        <div class="card-body p-4">
            <div class="p-2">
                <h5 class="mb-5 text-center">Devam edebilmek için oturum aç</h5>
                <form class="form-horizontal" action="javascript:;">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-4">
                                <label for="username">Kullanıcı Adı</label>
                                <input type="text" class="form-control" id="username" placeholder="Kullanıcı adınızı girin">
                            </div>
                            <div class="form-group mb-4">
                                <label for="password">Şifre</label>
                                <input type="password" class="form-control" id="password" placeholder="Şifrenizi girin">
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-success btn-block waves-effect waves-light" id="login">Oturum Aç</button>
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#login").on("click", function(){
            var username = $("#username").val();
            var password = $("#password").val();
    
            axios.post('/auth/login', {username:username, password:password}).then((res) => {
                toastr[res.data.type](res.data.message);
                if(res.data.status){
                    setInterval(function(){
                        window.location.assign('/');
                    }, 1000)
                }
            })
        })
    </script>
@endsection