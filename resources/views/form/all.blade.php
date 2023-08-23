@extends('master')

@section('title', 'Tüm Formlar')


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Tüm Formlar</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">#</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Formlar</a></li>
                        <li class="breadcrumb-item active">Tüm Formlar</li>
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

                    <h4 class="header-title">Form Listesi</h4>
                    <p class="card-title-desc">
                        Kullanıcılarınızın doldurabileceği formlar aşağıdaki listededir. Yeni bir form eklemek için menüyü kullanın. Forma soru eklemek ya da detaylarını görüntülemek için aksiyon menüsünü kullanın.
                    </p>

                    <table id="datatable" class="datatable table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Form Başlığı</th>
                            <th>Form Açıklaması</th>
                            <th>Soru Sayısı</th>
                            <th>Durum</th>
                            <th>İşlem</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach ($forms as $form)
                        <tr>
                            <td>{{$form->id}}</td>
                            <td>{{$form->title}}</td>
                            <td>{{$form->detail ?? "-"}}</td>
                            <td>{{$form->Questions->count()}}</td>
                            <td>
                                @if ($form->status == 0)
                                    <span class="badge bg-danger text-white">Pasif</span>
                                @else
                                <span class="badge bg-success text-white">Aktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                      İşlem
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="/form/detail/{{$form->id}}">Görüntüle</a>
                                      <a class="dropdown-item" href="/form/edit/{{$form->id}}">Düzenle</a>
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
        })
    </script>
@endsection