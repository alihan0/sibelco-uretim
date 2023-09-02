@extends('master')

@section('title', 'Pano')

@section('style')
<link href="/static/assets/libs/slick-slider/slick/slick.css" rel="stylesheet" type="text/css" />
<link href="/static/assets/libs/slick-slider/slick/slick-theme.css" rel="stylesheet" type="text/css" />

@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Pano</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">#</a></li>
                    <li class="breadcrumb-item active">Pano</li>
                </ol>
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
                        <h5 class="font-size-14">Toplam Form</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="fas fa-file"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center">{{$data["total_form"]}}</h4>
                
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <h5 class="font-size-14">Alt Form</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="fas fa-pager"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center">{{$data["total_subform"]}}</h4>
                
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <h5 class="font-size-14">Doldurulan Form</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="fas fa-file-alt"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center">{{$data["total_survey"]}}</h4>
                
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <h5 class="font-size-14">Toplam Soru</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="fas fa-question"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center">{{$data["total_question"]}}</h4>
                
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <h5 class="font-size-14">Toplam Hesap</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center">{{$data["total_user"]}}</h4>
                
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <h5 class="font-size-14">Toplam Tesis</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="fas fa-building"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center">{{$data["total_facility"]}}</h4>
                
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body">
                <div class="media">
                    <div class="media-body">
                        <h5 class="font-size-14">Toplam Birim</h5>
                    </div>
                    <div class="avatar-xs">
                        <span class="avatar-title rounded-circle bg-primary">
                            <i class="fas fa-layer-group"></i>
                        </span>
                    </div>
                </div>
                <h4 class="m-0 align-self-center">{{$data["total_unit"]}}</h4>
                
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Aylık Form Doldurma Dağılımı</h4>
                <div id="chart" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">Haftalık Form Doldurma Dağılımı</h4>
                <div id="chart2" class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">Son 10 Form</h4>
                
                <ul class="list-group">
                    @foreach ($data["last_surveys"] as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span><b>{{$item->id}}</b></span>
                            <span>{{$item->Form->title}}</span>
                        </li>
                    @endforeach
                  </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-4">Son 10 Bildirim</h4>

                <ul class="list-group">
                    @foreach ($data["last_notifications"] as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span><b>{{$item->title}}</b></span>
                            <span>{{substr($item->message, 0, 30)}}</span>
                        </li>
                    @endforeach
                  </ul>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title mb-4">Sorun Yaşanan Birimler</h4>
        
                        <div dir="ltr">
                            
                            <div class="slick-slider slider-for hori-timeline-desc pt-0">
                                <div>
                                    <p class="font-size-16">Daily Earning</p>
                                    <h4 class="mb-4">$ 1,452</h4>
                                    <div id="earning-day-chart" class="apex-charts"></div>
                                </div>
                                <div>
                                    <p class="font-size-16">Weekly Earning</p>
                                    <h4 class="mb-4">$ 6,536</h4>
                                    <div id="earning-weekly-chart" class="apex-charts"></div>
                                </div>
                                <div>
                                    <p class="font-size-16">Monthly Earning</p>
                                    <h4 class="mb-4">$ 24,562</h4>
                                    <div id="earning-monthly-chart" class="apex-charts"></div>
                                </div>
                                <div>
                                    <p class="font-size-16">Yearly Earning</p>
                                    <h4 class="mb-4">$ 2,82,562</h4>
                                    <div id="earning-yearly-chart" class="apex-charts"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Son Onay Kodları</h4>
        
                        <ul class="list-group">
                            @foreach ($data["confirms"] as $item)
                                <li class="list-group-item d-flex justify-content-center">
                                    <span><b>{{$item->code}}</b></span>
                                </li>
                            @endforeach
                          </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="/static/assets/libs/apexcharts/apexcharts.min.js"></script>
<script src="/static/assets/libs/slick-slider/slick/slick.min.js"></script>
<script>
    var options = {
          series: [{
          name: 'Series 1',
          data: [{{$data["m"][0]}}, {{$data["m"][1]}}, {{$data["m"][2]}}, {{$data["m"][3]}}, {{$data["m"][4]}}, {{$data["m"][5]}}, {{$data["m"][6]}},{{$data["m"][7]}},{{$data["m"][8]}},{{$data["m"][9]}},{{$data["m"][10]}},{{$data["m"][11]}}],
        }],
          chart: {
          height: 350,
          type: 'radar',
        },
        xaxis: {
          categories: ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık']
        }
    };
    var options2 = {
          series: [{
          name: 'Series 1',
          data: [
            
            {{$data["h"][1]->count}},
            {{$data["h"][2]->count}},
            {{$data["h"][3]->count}},
            {{$data["h"][4]->count}},
            {{$data["h"][5]->count}},
          ],
        }],
          chart: {
          height: 350,
          type: 'radar',
        },
        xaxis: {
          categories: ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar']
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
    chart2.render();


    $(".slider-fo21r").slick({slidesToShow:1,slidesToScroll:1,arrows:!1,autoplay:!0})
    $(".slider-n12av").slick({slidesToShow:3,slidesToScroll:1,asNavFor:".slider-for",arrows:!1,dots:!1,centerMode:!0,focusOnSelect:!0,responsive:[{breakpoint:1680,settings:{slidesToShow:2,slidesToScroll:2}},{breakpoint:1440,settings:{slidesToShow:1,slidesToScroll:1}},{breakpoint:1200,settings:{slidesToShow:3,slidesToScroll:3}},{breakpoint:600,settings:{slidesToShow:2,slidesToScroll:2}},{breakpoint:480,settings:{slidesToShow:1,slidesToScroll:1}}]})


    $('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
});

</script>

@endsection