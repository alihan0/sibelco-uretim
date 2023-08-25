@extends('master')

@section('title', 'Formlar')

@section('style')
<style>
    
    input[type="radio"] {
      display: none;
    }
    
    input[type="radio"]:not(:disabled) ~ label {
      cursor: pointer;
    }
    
    input[type="radio"]:disabled ~ label {
      color: hsla(150, 5%, 75%, 1);
      border-color: hsla(150, 5%, 75%, 1);
      box-shadow: none;
      cursor: not-allowed;
    }
    
    label {
      height: 100%;
      display: block;
      background: white;
      border: 2px solid hsla(150, 75%, 50%, 1);
      border-radius: 20px;
      padding: 1rem;
      margin-bottom: 1rem;
      text-align: center;
      box-shadow: 0px 3px 10px -2px hsla(150, 5%, 65%, 0.5);
      position: relative;
    }
    
    input[type="radio"]:checked + label {
      background: #16a34a;
      color: hsla(215, 0%, 100%, 1);
      border-color:#16a34a;
      box-shadow: 0px 0px 20px #047857
    }
    
    input[type="radio"].sorunvar:checked + label {
      background: #dc2626;
      border-color: #dc2626;
      box-shadow: 0px 0px 20px #991b1b
    }
    input[type="radio"].sorunvar + label {

      border-color: #dc2626;
    }
    
    p {
      font-weight: 900;
    }
    
    @media only screen and (max-width: 700px) {
      section {
        flex-direction: column;
      }
    }
    </style>
@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Formlar</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">#</a></li>
                    <li class="breadcrumb-item active">Formlar</li>
                </ol>
            </div>
            
        </div>
    </div>
</div>




      <div class="row">
        @foreach ($forms as $form)
        <div class="col-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                  <h4 class="my-0 font-weight-normal">{{$form->title}}</h4>
                </div>
                <div class="card-body">
                  <h1 class="card-title pricing-card-title">{{$form->Questions->count()}} <small class="text-muted">Soru</small>  </h1>
                  <p class="text-muted mb-5">
                    {{$form->detail}}
                  </p>
                  <button type="button" class="btn btn-lg btn-block btn-outline-primary" onclick="startForm({{$form->id}})">Başla</button>
                </div>
              </div>
        </div>
        @endforeach
      </div>
      
      
<input type="hidden" id="facilities" value="{{$facilities}}">
@endsection

@section('script')
    <script>
        $.fn.modal.Constructor.prototype._enforceFocus = function () {}
       function startForm(form_id) {
        var facilitiesJSON = $("#facilities").val();
        var options = {}; // Boş bir obje oluştur
        var facilities = JSON.parse(facilitiesJSON);


        facilities.forEach(element => {
            options[element.id] = element.title;
        });

        swal.fire({
            title: 'Hangi Tesis Bakıma Alınıyor?',
            input: 'select',
            inputOptions: options, // Doğru seçenekleri obje olarak ekleyin
            inputAttributes: {
                className: 'form-control'
            },
            showCloseButton: true,
        }).then((next) =>{
            if(next.value){
                var tesis_id = next.value;

                swal.fire({
                    title : "Tesisin Durumu Nedir?",
                    showConfirmButton: true,
                    showCancelButton: true,
                    showCloseButton: true,
                    cancelButtonText:'<i class="fas fa-power-off"></i> Kapalı',
                    confirmButtonText:'<i class="fas fa-power-off"></i> Açık',
                    confirmButtonColor: "green",
                    cancelButtonColor: "red",
                    focusConfirm: false,
                }).then((next)=>{
                    var tesis_durum;
                    if(next.value){
                        tesis_durum = 1;
                    }else{
                        tesis_durum = 0;
                    }

                    var draft = formaBasla(form_id,tesis_id, tesis_durum);
                    soruSor(form_id, 1, draft.draft, draft.key);

                });

            }
        });
    }

function soruSor(formid, soru, draft, key){
    axios.post('/get-questions', {formid:formid, soru:soru}).then((res) => {
        if(res.data.soru){
            var requiredConfirm = "";
            
            var nextButton = '<button type="button" class="btn btn-primary" id="nextButton">İleri</button>';
            if(res.data.soru.confirmation){
                var options = "";
                axios.post('/get-admins').then((admins) => {
                    console.log(admins)
                    admins.data.forEach(element => {
                        $("#selectAdmin").append('<option value="'+element.id+'">'+element.name+'</option>');
                    });
                })

                requiredConfirm = '<div class="alert alert-warning row" role="alert">'+
                                    '<span class="col-6">Bu soru için yönetici onayı gerekmektedir: </span>'+
                                    '<input type="hidden" id="selectAdminSoru" value="'+res.data.soru.id+'">'+
                                    '<select class="form-control col-6" id="selectAdmin">'+
                                        '<option value="0">Yönetici Seçin...</option>'+
                                    '</select>'+
                                '</div>';


                nextButton = '<button type="button" class="btn btn-primary" id="nextButton" disabled>İleri</button>';
            }
            $("body").append('<div class="modal fade" id="SoruModal" tabindex="-1" data-backdrop="static" data-keyboard="false"  aria-labelledby="exampleModalLabel" aria-hidden="true">'+
                '<div class="modal-dialog">'+
                    '<div class="modal-content">'+
                    '<div class="modal-header">'+
                        '<h5 class="modal-title" id="SoruModal">Soru : '+soru+'</h5>'+
                        '<span aria-hidden="true">&times;</span>'+
                        '</button>'+
                    '</div>'+
                    '<div class="modal-body">'+
                        '<span style="font-weight:bold; font-size:1.3rem">'+res.data.soru.title+'</span>'+
                        '<hr>'+
                        '<div class="form-check mb-4 ">'+
                            '<input class="sorunvar"  type="radio" name="cevaplar" id="sorunVar"  value="0" >'+
                            '<label  for="sorunVar">Sorun Var</label>'+
                        '</div>'+
                        '<div class="form-check mb-4">'+
                            '<input type="radio" name="cevaplar" id="sorunYok" value="1" checked>'+
                            '<label for="sorunYok">Sorun Yok</label>'+
                        '</div>'+
                        requiredConfirm+
                    '</div>'+
                    '<div class="modal-footer d-flex justify-content-between">'+
                        '<input type="text" class="form-control col-8" placeholder="Notlarınız" id="not">'+
                        nextButton+
                    '</div>'+
                    '</div>'+
                '</div>'+
                '</div>');
        $("#SoruModal").modal("show");
        $("#nextButton").on("click", function(){
            var cevap = $("input[name='cevaplar']:checked").val();
            var not = $("#not").val();
            alert(not)
            soruKaydet(formid,soru, cevap, not, draft, key);
            $("#SoruModal").remove()
            $('.modal-backdrop').remove();
            
        })
        }else{
            alert("son soruydu")
        }
        
    });
    
}

$(document).on("change", "#selectAdmin", function(){
    var admin = $(this).val();
    var soru = $("#selectAdminSoru").val();
    
    axios.post('/send-confirmation-code', {admin:admin, soru:soru}).then((res) => {
        if(res.data.status){
            swal.fire({
                'title' : "Onay Kodu:",
                "text" : "Seçtiğiniz yöneticiye 6 haneli bir onay kodu gönderildi. Lütfen gönderilen kodu aşağıdaki alana girin.",
                "input" : "text",
                "confirmButtonText" : "Onayla",
                "showCancelButton" : false,
                "allowOutsideClick" : false,
                preConfirm: (code) => {
                    return axios.post('/control-confirmation-code', { code })
                        .then(response => {
                            if (!response.data.ok) {
                                throw new Error(response.statusText)
                            }
                            $("#nextButton").attr('disabled', false);
                            return response.data; // Sadece response.data kullanın
                        })
                        .catch(error => {
                            console.log(error)
                            Swal.showValidationMessage(`Hata: ${error}`);
                        });
                },
            }).then((code) => {
                if(code){
                    
                }
            });
        }
    });
})
function soruKaydet(formid, soru, cevap, not, draft, key){
    soru++;
    axios.post('/save/answer', {key:key, form:formid, soru:soru, cevap:cevap, not:not, draft:draft, key:key}).then((res) => {
        toastr[res.data.type](res.data.message);
    });
    soruSor(formid, soru)
}


function formaBasla(form,tesis,tesis_durum){
    axios.post('/form/save/anket', {form:form,tesis:tesis,tesis_durum:tesis_durum}).then((res) => {
        if(res.data.status){
            return {key : res.data.key, draft:res.data.draft};
        }
    })
}
    </script>
@endsection