@extends('master')

@section('title', 'Form Arşivi')


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Form Arşivi</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">#</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Formlar</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Form Arşivi</a></li>
                        <li class="breadcrumb-item active">Bu Ay Doldurulan Formlar</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row mb-4">
        <div class="col ">
            <ul class="nav nav-pills  bg-light">
                <li class="nav-item">
                  <a class="nav-link " aria-current="page" href="/archive">Son 10 Form</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="/archive/month">Bu Ay</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/archive/3month">3 Ay</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/archive/all">Tüm Zamanlar</a>
                  </li>
              </ul>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                  
                    

                    <table id="datatable" class="datatableOrder table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Form</th>
                            <th>Dolduran</th>
                            <th>Tesis/Birim</th>
                            <th>Tarih</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach ($surveys as $item)
                                <tr>
                                    <td><a href="/archive/detail/{{$item->id}}">{{$item->id}}</a></td>
                                    <td>{{$item->Form->title}}</td>
                                    <td>{{$item->User->name}}</td>
                                    <td>{{$item->Unit->Facility->title.'/'.$item->Unit->title}}</td>
                                    <td>{{$item->created_at}}</td>
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
    <script></script>
@endsection