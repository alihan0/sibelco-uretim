@extends('master')

@section('title', 'Form Detayları')
    
@section('content')
<input type="hidden" id="form_id" value="{{$form->id}}">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Form Detayları - ID#{{$form->id}}</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">#</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Formlar</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Form Detayları</a></li>
                        <li class="breadcrumb-item active">Form ID: {{$form->id}}</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body bg-primary rounded">
                    
                    <h4 class="card-title mb-0 text-white justify-content-between d-flex">
                        <span>{{$form->title}}</span>
                        <a href="javascript:;" class="btn btn-danger btn-sm" onclick="deleteForm({{$form->id}})" data-toggle="tooltip" title="Sil"><i class="fas fa-trash"></i></a>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body">
                            <h5 class="font-size-14">Toplam Soru Sayısı</h5>
                        </div>
                        <div class="avatar-xs">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="dripicons-box"></i>
                            </span>
                        </div>
                    </div>
                    <h4 class="m-0 align-self-center">{{$form->Questions->count()}}</h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body">
                            <h5 class="font-size-14">Toplam İşlem Sayısı</h5>
                        </div>
                        <div class="avatar-xs">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="dripicons-box"></i>
                            </span>
                        </div>
                    </div>
                    <h4 class="m-0 align-self-center">#<h4>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body">
                            <h5 class="font-size-14">Alt Form Sayısı</h5>
                        </div>
                        <div class="avatar-xs">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="dripicons-box"></i>
                            </span>
                        </div>
                    </div>
                    <h4 class="m-0 align-self-center">{{$form->Attachments->count()}}</</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title justify-content-between d-flex">
                        <span>Sorular</span>
                        <a href="javascript:;" class="btn btn-success" data-toggle="modal" data-target="#addQuestionModal"><i class="fas fa-plus"></i> Soru Ekle</a>
                    </h4>
                    <p class="card-title-desc">
                        Bu form başlatıldığı zaman sorulacak sorular aşağıdaki listededir.
                    </p>

                    <table id="datatable" class="datatable table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sıra NO</th>
                            <th>Soru Başlığı</th>
                            <th>Soru</th>
                            <th>Yönetici Onayı</th>
                            <th>Durum</th>
                            <th>İşlem</th>
                        </tr>
                        </thead>


                        <tbody>
                        @foreach ($form->Questions as $item)
                        <tr>
                            <td>{{$item->id}}</td>
                            <td>{{$item->align}}</td>
                            <td>{{$item->title}}</td>
                            <td>{{$item->question}}</td>
                            <td>
                                @if ($item->confirmation == 0)
                                    <span class="badge bg-warning text-white">Yok</span>
                                @else
                                <span class="badge bg-success text-white">Gerekli</span>
                                @endif
                            </td>
                            <td>
                                @if ($item->status == 0)
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
                                      
                                    @if ($item->status == 0)
                                    <a class="dropdown-item" href="javascript:;" onclick="makeActive({{$item->id}})">Aktif Yap</a>
                                    @else
                                    <a class="dropdown-item" href="javascript:;" onclick="makePassive({{$item->id}})">Pasif Yap</a>
                                    @endif

                                    <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#attach{{$item->id}}">Alt Form Ekle</a>
                                    <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#editQuestionModal{{$item->id}}">Düzenle</a>
                                    <a class="dropdown-item" href="javascript:;" onclick="deleteQuestion({{$item->id}})">Sil</a>
                                    
                                    </div>
                                  </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="editQuestionModal{{$item->id}}" tabindex="-1" aria-labelledby="editQuestionModal{{$item->id}}Label" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="editQuestionModal{{$item->id}}Label">Soru Düzenle</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <form action="javascript:;" id="editQuestionForm{{$item->id}}">
                                        <input class="form-control" type="hidden" value="{{$item->id}}" id="id" name="id">
                                        <div class="form-group row">
                                            <label for="align" class="col-md-4 col-form-label">Soru Sırası:</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" value="{{$item->align}}" id="align" name="align">
                                                
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="title" class="col-md-4 col-form-label">Soru Başlığı:</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" value="{{$item->title}}" id="title" name="title">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="question" class="col-md-4 col-form-label">Sorunuz:</label>
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" value="{{$item->question}}" id="question" name="question">
                                            </div>
                                        </div>
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input type="checkbox" class="custom-control-input" id="confirm" name="confirm" {{$item->confirmation == 1 ? "checked":""}}>
                                            <label class="custom-control-label" for="confirm">Bu soru yönetici onayı gerektirsin</label>
                                        </div>
                                        
                                    </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Vazgeç</button>
                                  <button type="button" class="btn btn-primary" onclick="editQuestion({{$item->id}})">Kaydet</button>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="modal fade" id="attach{{$item->id}}" tabindex="-1" aria-labelledby="attach{{$item->id}}Label" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="attach{{$item->id}}Label">Alt Form Ekle</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                    <form action="javascript:;" id="attachForm{{$item->id}}">
                                        <input class="form-control" type="hidden" value="{{$item->id}}" id="id" name="id">
                                        <input class="form-control" type="hidden" value="{{$form->id}}" id="form" name="form">

                                        <div class="form-group row">
                                            <label for="subform" class="col-md-4 col-form-label">Alt Form Seçin:</label>
                                            <div class="col-md-8">
                                                
                                                <select name="subform" id="subform" class="form-control">
                                                    <option value="0">Seçin</option>
                                                    @foreach ($subforms as $s)
                                                        <option value="{{$s->id}}">{{$s->title}}</option>
                                                    @endforeach
                                                </select>
                                                
                                            </div>
                                        </div>  
                                    </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Vazgeç</button>
                                  <button type="button" class="btn btn-primary" onclick="attach({{$item->id}})">Kaydet</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                        
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div>



<!-- Modal -->
<div class="modal fade" id="addQuestionModal" tabindex="-1" aria-labelledby="addQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addQuestionModalLabel">Soru Ekle</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <label for="align" class="col-md-4 col-form-label">Soru Sırası:</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" placeholder="Formun görünen adını girin" id="align">
                </div>
            </div>
            <div class="form-group row">
                <label for="title" class="col-md-4 col-form-label">Soru Başlığı:</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" placeholder="Formun görünen adını girin" id="title">
                </div>
            </div>
            <div class="form-group row">
                <label for="question" class="col-md-4 col-form-label">Sorunuz:</label>
                <div class="col-md-8">
                    <input class="form-control" type="text" placeholder="Formun görünen adını girin" id="question">
                </div>
            </div>
            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" class="custom-control-input" id="confirm">
                <label class="custom-control-label" for="confirm">Bu soru yönetici onayı gerektirsin</label>
            </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Vazgeç</button>
          <button type="button" class="btn btn-primary" onclick="addQuestion()">Ekle</button>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
    <script>
        // FORM SİL
        function deleteForm(id){
            Swal.fire({
                title: 'Emin misin?',
                text: "Dikkat! Bu işlem geri alınamaz. Bir formu sildiğiniz zaman o forma artık ulaşılamaz ve formun kullanıldığı statik sayfalar hata verebilir.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Evet, Kalıcı Olarak Sil',
                cancelButtonText: 'Vazgeç'
            }).then((result) => {
                if (result.value) {
                    axios.post('/form/delete/', {id:id}).then((res) => {
                        if(res.data.status){
                            Swal.fire(
                                'Başarılı!',
                                'Form başarıyla silindi.',
                                'success'
                            ).then((ok) => {   
                                if(ok.value){
                                    window.location.assign('/form/all');
                                }
                            });

                        }
                    });
                }
            })
        }
        // SORU EKLE
        function addQuestion(){
            var form = $("#form_id").val();
            var align = $("#align").val();
            var title = $("#title").val();
            var question = $("#question").val()
            var confirmed;

            if ($('#confirm').is(':checked')) {
                confirmed = 1;
            }else{
                confirmed = 0;
            }

            axios.post('/form/add/question', {form:form, align:align, title:title, question:question, confirmed:confirmed}).then((res) => {
                if(res.data.status){
                    window.location.reload()
                }else{
                    toastr[res.data.type](res.data.message);
                }
            });
        }
        // SORUYU PASİF YAP
        function makePassive(id){
            axios.post('/form/set/passive', {id:id}).then((res) => {
                if(res.data.status){
                    window.location.reload();
                }
            });
        }
        // SORUYU AKTİF YAP
        function makeActive(id){
            axios.post('/form/set/active', {id:id}).then((res) => {
                if(res.data.status){
                    window.location.reload();
                }
            });
        }
        // SORUYU SİL
        function deleteQuestion(id){
            axios.post('/form/delete/question', {id:id}).then((res) => {
                if(res.data.status){
                    window.location.reload();
                }
            });
        }
        // SORUYU DÜZENLE
        function editQuestion(id){
            var formData = $("#editQuestionForm"+id).serialize();

            axios.post('/form/update/question', formData).then((res) =>{
                if(res.data.status){
                    window.location.reload();
                }
            });
        }
        // SORUYA ALT FORM EKLE
        function attach(id){
            var formData = $("#attachForm"+id).serialize();
            axios.post('/form/attach', formData).then((res) => {
                if(res.data.status){
                    window.location.reload();
                }
            });
        }
    </script>
@endsection