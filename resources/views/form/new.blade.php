@extends('master')

@section('title', 'Yeni Form Oluştur')


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Yeni Form</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">#</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Formlar</a></li>
                        <li class="breadcrumb-item active">Yeni Form</li>
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

                    
                    

                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label">Form Başlığı:</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" placeholder="Formun görünen adını girin" id="title">
                        </div>
                        <div class="col-4">
                            <p class="text-muted">
                                Formun listeleme alanlarında görüneceği adıdır. Kullanıcılar formları bu isimlere göre birbirinden ayırt edebilir.
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="detail" class="col-md-4 col-form-label">Form Açıklaması:</label>
                        <div class="col-md-4">
                            <textarea name="" class="form-control" id="detail" placeholder="Formun açılmaasını ya da detaylarını girin" rows="10"></textarea>
                        </div>
                        <div class="col-4">
                            <p class="text-muted">
                                Bu alan, kullanıcıların form hakkında ön bilgi sahibi olacağı ve kullanıcılara bu formun hangi amaçla doldurulması gerektiğinin bilgisinin verileceği alandır.
                            </p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label">E-posta Alıcıları:</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" placeholder="E-posta adreslerini girin" id="email">
                        </div>
                        <div class="col-4">
                            <p class="text-muted">
                                Forma not eklenirse bu adreslere e-posta gönderilecek. Birden fazla eposta girmek için eposta adresini virgül (,) ile ayırın.
                            </p>
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
        })
    </script>
@endsection