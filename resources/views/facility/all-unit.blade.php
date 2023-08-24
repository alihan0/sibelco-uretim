@extends('master')

@section('title', 'Tüm Birimler')


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Tüm Birimler</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">#</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tesisler</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Birimler</a></li>
                        <li class="breadcrumb-item active">Tüm Birimler</li>
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

                    <h4 class="header-title">Tesis Listesi</h4>
                    <p class="card-title-desc">
                        Aşağıdaki listede sistemde kayıtlı olan tüm birimleri görüntüleyebilirsiniz. Yeni birim eklemek için menüyü kullanın. Birim üzerinde işlem yapmak için aksiyon menüsünü kullanın.
                    </p>

                    <table id="datatable" class="datatable table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tesis Adı</th>
                            <th>Birim Adı</th>
                            <th>Açıklama</th>
                            <th>İşlem</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach ($units as $unit)
                        <tr>
                            <td>{{$unit->id}}</td>
                            <td>{{$unit->Facility->title}}</td>
                            <td>{{$unit->title}}</td>
                            <td>{{$unit->detail}}</td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                                      İşlem
                                    </button>
                                    <div class="dropdown-menu">
                                      <a class="dropdown-item" href="javascript:;" onclick="changeTitle({{$unit->id}})">Adını Değiştir</a>
                                      <a class="dropdown-item" href="javascript:;" onclick="deleteFacility({{$unit->id}})">Sil</a>
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

        
        function deleteFacility(id){
            Swal.fire({
                title: 'Emin misin?',
                text: "Dikkat! Bu işlem geri alınamaz. Bir tesisi sildiğinizde, tesis artık kullanılamaz ve tesinin seçili olduğu form arşivleri hata verebilir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, Kalıcı Olarak Sil',
                cancelButtonText: 'Vazgeç'
            }).then((result) => {
                if (result.value) {
                    axios.post('/facility/delete/', {id:id}).then((res) => {
                        if(res.data.status){
                            Swal.fire(
                                'Başarılı!',
                                'Tesis başarıyla silindi.',
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

        function changeTitle(id){
            Swal.fire({
                title: 'Tesisin Adını Değiştir',
                input: "text",
                inputAttributes: {
                    placeholder: 'Tesisin Yeni Adı '
                },
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Değiştir',
                cancelButtonText: 'Vazgeç'
            }).then((result) => {
                if (result.value) {
                    axios.post('/facility/rename/', {id:id, title:result.value}).then((res) => {
                        if(res.data.status){
                            Swal.fire(
                                'Başarılı!',
                                'Tesis Adı Değiştirildi',
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