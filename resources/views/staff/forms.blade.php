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
                  <button type="button" class="btn btn-lg btn-block btn-outline-primary" onclick="Draft.startForm({{$form->id}})">Başla</button>
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
      </script>
   <script src="/static/assets/js/form.js"></script>
@endsection