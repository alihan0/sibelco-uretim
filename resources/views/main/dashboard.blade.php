@extends('master')

@section('title', 'Pano')


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
                <h4 class="m-0 align-self-center">1,753</h4>
                
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
                <h4 class="m-0 align-self-center">1,753</h4>
                
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
                <h4 class="m-0 align-self-center">1,753</h4>
                
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
                <h4 class="m-0 align-self-center">1,753</h4>
                
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
                <h4 class="m-0 align-self-center">1,753</h4>
                
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
                <h4 class="m-0 align-self-center">1,753</h4>
                
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
                <h4 class="m-0 align-self-center">1,753</h4>
                
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
@endsection

@section('script')
<script src="/static/assets/libs/apexcharts/apexcharts.min.js"></script>

<script>
    var options = {
          series: [{
          name: 'Series 1',
          data: [80, 50, 30, 40, 100, 20, 2,3,54,6,3,2],
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
          data: [20,30,20,40,50],
        }],
          chart: {
          height: 350,
          type: 'radar',
        },
        xaxis: {
          categories: ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma']
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();

    var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
    chart2.render();

</script>

@endsection