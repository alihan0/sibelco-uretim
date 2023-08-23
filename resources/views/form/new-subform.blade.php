@extends('master')

@section('title', 'Yeni Alt Form Oluştur')


@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Yeni Alt Form</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">#</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Formlar</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Alt Formlar</a></li>
                        <li class="breadcrumb-item active">Yeni Alt Form</li>
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
                        <label for="form" class="col-md-4 col-form-label">Form Başlığı:</label>
                        <div class="col-md-4">
                            <select class="form-control" id="form">
                                <option value="0">Seçin</option>
                                @foreach ($forms as $form)
                                    <option value="{{$form->id}}">{{$form->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>

                    

                    <div class="form-group row">
                        <label for="title" class="col-md-4 col-form-label">Form Başlığı:</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" placeholder="Alt form başlığını girin" id="title">
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
            var form = $("#form").val();

            axios.post('/form/save/subform', {title:title, form:form}).then((res) => {
                toastr[res.data.type](res.data.message);
                if(res.data.status){
                    setInterval(() => {
                        window.location.assign('/form/detail/subform/'+res.data.id);
                    }, 500);
                }
            });
        })
    </script>
@endsection