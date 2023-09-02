@extends('master')

@section('title')
Form : {{$survey->key}}
@endsection
@section('style')
    <link rel="stylesheet" href="/static/assets/libs/lightbox2/css/lightbox.css">
    
@endsection

@section('content')
        <nav class="page-breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="#">Form Arşivi</a></li>
    <li class="breadcrumb-item"><a href="#">Form Detayları</a></li>
    <li class="breadcrumb-item active" aria-current="page">Form: {{$survey->key}}</li>
  </ol>
</nav>

<div class="row">
  <div class="col-md-12">
    <div class="card"  id="print">
      <div class="card-body">
        <div class="container-fluid d-flex justify-content-between">
          <div class="col-lg-3 ps-0">
            <a href="#" class="noble-ui-logo d-block mt-3">Sibelco<span>Üretim</span></a>                 
            <h5 class="mt-3 mb-2 text-muted">Formu Dolduran:</h5>
            
            <p>{{$survey->User->name}} <br><span class="text-muted">({{'@'.$survey->User->username}})</span><br> {{$survey->User->email}}<br> {{$survey->User->phone}}</p>

        

            <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted">Tesis :</span> {{$survey->Unit->Facility->title}}  <span class="text-muted ml-4">Birim :</span> {{$survey->Unit->title}}</h6>

            <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted">Durum :</span>  {!! $survey->unit_status == 1 ? '<span class="badge bg-success text-white p-2">Açık</span>' : '<span class="badge ml-2 bg-danger text-white">Kapalı</span>' !!}  </h6>
            
          </div>
          <div class="col-lg-3 pe-0">
            <h4 class="fw-bold text-uppercase text-end mt-4 mb-2">Form</h4>
            <h6 class="text-end mb-5 pb-4"># {{$survey->key}}</h6>
            
            
            <h6 class="mb-0 mt-3 text-end fw-normal mb-2"><span class="text-muted">Oluşturulma Tarihi :</span></h6>
            <h6 class="text-end fw-normal">  {{$survey->created_at}}</h6>

          </div>
        </div>
        <div class="container-fluid mt-5 d-flex justify-content-center w-100">
          <div class="table-responsive w-100">
              <table class="table table-bordered">
                <thead>
                  <tr>
                      <th>Soru</th>
                      <th class="">Yanıt</th>
                      <th class="text-end">Fotoğraf</th>
                      <th class="text-end">Onay</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($survey->Answer as $item)
                  <tr class="text-end">
                    <td class="text-start">{{$item->Question->title ?? "-"}}</td>
                    <td class="d-flex justify-content-between">
                        {!! $item->answer == 1 ? '<span class="badge bg-success text-white p-2">Sorun Yok</span>' : '<span class="badge p-2 bg-danger text-white">Sorun Var</span>' !!}  <span class="ml-4 text-muted"><b>Not:</b> {{$item->note}}</span>
                    </td>
                    <td>
                        
                        @if ($item->file)
                        <a class="example-image-link" href="{{$item->file}}" data-lightbox="example-1"><img width="40" class="example-image" src="{{$item->file}}" alt="image-1" /></a>
                        @else
                            -
                        @endif


                    </td>
                    <td>
                        {!! ! $item->confirm_code ? '-' : 'Kod: '. $item->confirm_code .'<br>'. $item->Confirmative->name !!}
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-6">
                <h4 class="card-title ml-3">İmza:</h4>
                <hr>
                <div class="container-fluid d-flex  w-100 " >
                    
                    <img src="{{$survey->signature}}" alt="SVG" class="border">

                </div>
            </div>
            <div class="col-6">
                <h4 class="card-title">Alt Formlar:</h4>
                <hr>
                <div class="container-fluid w-100 " >
                  
                    @foreach ($groupedSubforms as $subformAnswers)
                    <h4 class="card-title"></h4>
                    <ul class="list-group mb-4">
                        @foreach ($subformAnswers as $subformAnswer)
                            <li class="list-group-item d-flex justify-content-between">
                                <span>{{ $subformAnswer->Question->title }}</span>
                                <span>{{ $subformAnswer->answer }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endforeach

                      
                    
                </div>
            </div>
        </div>
        
      </div>
      
    </div>
    
  </div>
</div>
<div class="row mb-4">
    <div class="col">
        <div class="container-fluid w-100">
            <a href="javascript:;" id="printBtn" class="btn btn-outline-primary float-end mt-4"><i data-feather="printer" class="me-2 icon-md"></i>Print</a>
          </div>
    </div>
</div>
@endsection

@section('script')
    <script src="/static/assets/libs/lightbox2/js/lightbox.js"></script>
    <script src="/static/assets/js/pages/jQuery.print.min.js"></script>
    <script>
        lightbox.option({
          'resizeDuration': 200,
          'wrapAround': true
        });

        

$("#printBtn").on("click", function(){
    $("#print").print({
        addGlobalStyles : true,
        stylesheet : null,
        rejectWindow : true,
        noPrintSelector : ".no-print",
        iframe : true,
        append : null,
        prepend : null
    });
})
    </script>
@endsection