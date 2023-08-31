@extends('master')

@section('title', 'Form Detayları')


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
    <div class="card">
      <div class="card-body">
        <div class="container-fluid d-flex justify-content-between">
          <div class="col-lg-3 ps-0">
            <a href="#" class="noble-ui-logo d-block mt-3">Sibelco<span>Üretim</span></a>                 
            <h5 class="mt-3 mb-2 text-muted">Formu Dolduran:</h5>
            
            <p>{{$survey->User->name}} <br><span class="text-muted">({{'@'.$survey->User->username}})</span><br> {{$survey->User->email}}<br> {{$survey->User->phone}}</p>
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
                      <th>#</th>
                      <th>Soru</th>
                      <th class="text-end">Yanıt</th>
                      <th class="text-end">Fotoğraf</th>
                      <th class="text-end">Onay</th>
                    </tr>
                </thead>
                <tbody>
                  <tr class="text-end">
                    <td class="text-start">1</td>
                    <td class="text-start">PSD to html conversion</td>
                    <td>02</td>
                    <td>$55</td>
                    <td>$110</td>
                  </tr>
                  <tr class="text-end">
                    <td class="text-start">2</td>
                    <td class="text-start">Package design</td>
                    <td>08</td>
                    <td>$34</td>
                    <td>$272</td>
                  </tr>
                  <tr class="text-end">
                    <td class="text-start">3</td>
                    <td class="text-start">Html template development</td>
                    <td>03</td>
                    <td>$500</td>
                    <td>$1500</td>
                  </tr>
                  <tr class="text-end">
                    <td class="text-start">4</td>
                    <td class="text-start">Redesign</td>
                    <td>01</td>
                    <td>$30</td>
                    <td>$30</td>
                  </tr>
                </tbody>
              </table>
            </div>
        </div>
        
        <div class="container-fluid w-100">
          <a href="javascript:;" class="btn btn-primary float-end mt-4 ms-2"><i data-feather="send" class="me-3 icon-md"></i>Send Invoice</a>
          <a href="javascript:;" class="btn btn-outline-primary float-end mt-4"><i data-feather="printer" class="me-2 icon-md"></i>Print</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
    <script></script>
@endsection