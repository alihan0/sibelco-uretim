@extends('master')

@section('title', 'Yeni Kullanıcı Oluştur')


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Yeni Tesis</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">#</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tesisler</a></li>
                        <li class="breadcrumb-item active">Yeni Tesis</li>
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
                        <label for="title" class="col-md-4 col-form-label">Tesis Adı:</label>
                        <div class="col-md-6">
                            <input class="form-control" type="text" placeholder="İsim soyisim girin" id="title">
                        </div>
                        
                    </div>

                    <div class="form-group row">
                        <label for="detail" class="col-md-4 col-form-label">Detaylar:</label>
                        <div class="col-md-6">
                            <textarea class="form-control" id="detail" placeholder="Tesis detaylarını girin (Zorunlu değil)" rows="10"></textarea>
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


            axios.post('/facility/save', {title:title, detail:detail}).then((res) => {
                toastr[res.data.type](res.data.message);
                if(res.data.status){
                    setInterval(() => {
                        window.location.assign('/facility/all/');
                    }, 500);
                }
            });
        })
    </script>
@endsection