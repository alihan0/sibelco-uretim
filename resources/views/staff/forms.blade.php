@extends('master')

@section('title', 'Formlar')


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
      
      
<input type="text" id="facilities" value="{{$facilities}}">
@endsection

@section('script')
    <script>
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

                soruSor(form_id, 1);

            });

        }
    });
}

function soruSor(formid, soru){
    axios.post('/get-questions', {formid:formid, soru:soru}).then((res) => {
        if(res.data.soru){
            $("body").append('<div class="modal fade" id="SoruModal" tabindex="-1" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">'+
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
                        '<div class="form-check mb-4">'+
                            '<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" >'+
                            '<label class="form-check-label" for="exampleRadios1">Sorun Var</label>'+
                            '</div>'+
                            '<div class="form-check">'+
                            '<input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2" checked>'+
                            '<label class="form-check-label" for="exampleRadios2">Sorun Yok</label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="modal-footer">'+
                        '<button type="button" class="btn btn-primary" id="nextButton">İleri</button>'+
                    '</div>'+
                    '</div>'+
                '</div>'+
                '</div>');
        $("#SoruModal").modal("show");
        $("#nextButton").on("click", function(){
            soruKaydet(formid,soru);
            $("#SoruModal").remove()
            $('.modal-backdrop').remove();
        })
        }else{
            alert("son soruydu")
        }
        
    })
}


function soruKaydet(formid, soru){
    soru++;
    soruSor(formid, soru)
}
    </script>
@endsection