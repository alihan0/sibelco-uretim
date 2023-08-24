@extends('master')

@section('title', 'Yeni Kullanıcı Oluştur')


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Yeni Kullanıcı</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">#</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Kullanıcılar</a></li>
                        <li class="breadcrumb-item active">Yeni Kullanıcı</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-body">

                    
                    

                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label">Kullanıcı Tipi:</label>
                        <div class="col-md-6">
                            <select class="form-control" id="type">
                                <option value="0">Seçin</option>
                                <option value="ADMIN">Yönetici</option>
                                <option value="USER">Kullanıcı</option>
                                <option value="BOTH">İkisi</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label">İsim:</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" placeholder="İsim soyisim girin" id="name">
                        </div>
                        
                    </div>

                    <div class="form-group row">
                        <label for="username" class="col-md-4 col-form-label">Kullanıcı Adı:</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" placeholder="Kullanıcı adı girin" id="username">
                        </div>
                        
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label">E-posta Adresi:</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" placeholder="E-posta adresi girin" id="email">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="phone" class="col-md-4 col-form-label">Telefon:</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" placeholder="Telefon numarası girin" id="phone">
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-primary float-end" id="save">Oluştur</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection

@section('script')
    <script>
        $("#save").on("click", function(){
            var type = $("#type").val();
            var name = $("#name").val();
            var username = $("#username").val();
            var email = $("#email").val();
            var phone = $("#phone").val();

            axios.post('/user/save', {type:type, name:name, username:username, email:email, phone:phone}).then((res) => {
                toastr[res.data.type](res.data.message);
                if(res.data.status){
                    setInterval(() => {
                        window.location.assign('/user/all/');
                    }, 500);
                }
            });
        })
    </script>
@endsection