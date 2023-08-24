@extends('master')

@section('title', 'Tüm Kullanıcılar')


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Tüm FormlKullanıcılarar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">#</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Kullanıcılar</a></li>
                        <li class="breadcrumb-item active">Tüm Kullanıcılar</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title">Kullanıcı Listesi</h4>
                    <p class="card-title-desc">
                        Aşağıdaki listede sistemde oturum açabilecek kullanıcıların listesini görüntüleyebilirsiniz. Yeni kullanıcı eklemek için menüyü kullanın. Kullanı  üzerinde işlem yapmak için aksiyon menüsünü kullanın.
                    </p>

                    <table id="datatable" class="datatable table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kullanıcı Tipi</th>
                            <th>İsim</th>
                            <th>Kullanıcı Adı</th>
                            <th>E-posta</th>
                            <th>Telefon</th>
                            <th>İşlem</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->type}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->phone}}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                      İşlem
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="javascript:;">Şifre Değiştir</a>
                                      <a class="dropdown-item" href="javascript:;" onclick="deleteUser({{$user->id}})">Sil</a>
                                    </div>
                                  </div>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection

@section('script')
    <script>
        $("#save").on("click", function(){
            var title = $("#title").val();
            var detail = $("#detail").val();
            var email = $("#email").val();

            axios.post('/form/save', {title:title, detail:detail, email:email}).then((res) => {
                toastr[res.data.type](res.data.message);
                if(res.data.status){
                    setInterval(() => {
                        window.location.assign('/form/detail/'+res.data.id);
                    }, 500);
                }
            });
        });

        
        function deleteUser(id){
            Swal.fire({
                title: 'Emin misin?',
                text: "Dikkat! Bu işlem geri alınamaz. Bir kullanıcıyı sildiğiniz zaman o kullanıcı artık  olur ve oturum açamaz.Ayrıca kullanıcının kullanıldığı statik sayfalar hata verebilir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, Kalıcı Olarak Sil',
                cancelButtonText: 'Vazgeç'
            }).then((result) => {
                if (result.value) {
                    axios.post('/user/delete/', {id:id}).then((res) => {
                        if(res.data.status){
                            Swal.fire(
                                'Başarılı!',
                                'Form başarıyla silindi.',
                                'success'
                            ).then((ok) => {   
                                if(ok.value){
                                    window.location.reload()
                                }
                            });

                        }
                    });
                }
            })
        }
    </script>
@endsection