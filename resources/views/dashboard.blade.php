@extends('layouts.admin')
@section('page', 'Inicio')
@section('title')
    {{ Breadcrumbs::render('home') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-6 col-lg-3 col-md-6">
            <div class="card">
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon purple mb-2">
                                <a href="{{ route('lotes.infoVencimientos') }}">
                                    <i class="iconly-boldShow"></i>
                                </a>
                                
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Lotes próximos a vencerse</h6>
                            <h6 class="font-extrabold mb-0">{{ $lotesProximosaVencer }}</h6>
                        </div>
                    </div> 
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6">
            <div class="card"> 
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon purple mb-2">
                                <a href="{{ route('lotes.infoStock') }}">
                                    <i class="iconly-boldShow"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Lotes con bajo stock</h6>
                            <h6 class="font-extrabold mb-0">{{ $lotesBajoStock }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6">
            <div class="card"> 
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon purple mb-2">
                                <a href="{{ route('insumos.estante') }}">
                                    <i class="iconly-boldShow"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Insumos registrados</h6>
                            <h6 class="font-extrabold mb-0">{{ $insumosRegistrados }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6">
            <div class="card"> 
                <div class="card-body px-4 py-4-5">
                    <div class="row">
                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                            <div class="stats-icon purple mb-2">
                                <a href="{{ route('productos.estante') }}">
                                    <i class="iconly-boldShow"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                            <h6 class="text-muted font-semibold">Productos registrados</h6>
                            <h6 class="font-extrabold mb-0">{{ $productosRegistrados }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Ventas registradas por mes</h5>
                </div>
                <div class="card-body">
                    @if(empty($ventas_data))
                        <p class="text-center text-muted">No hay datos disponibles para mostrar este gráfico.</p>
                    @else
                        <div id="chart"></div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card" style="height: 92.5%;">
                <div class="card-header">
                    <h5>Productos con bajo stock</h5>
                </div>
                <div class="card-body">
                    @if(empty($porcentajeStockBajo))
                        <p class="text-center text-muted">No hay datos disponibles para mostrar este gráfico.</p>
                    @else
                        <div id="chart3"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">
                    <h5>Productos más vendidos</h5>
                </div>
                <div class="card-body">
                    @if(empty($cantProductosVendidos))
                        <p class="text-center text-muted">No hay datos disponibles para mostrar este gráfico.</p>
                    @else
                        <div id="chart2"></div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5>Cantidad de productos vendidos por día</h5>
                </div>
                <div class="card-body">
                    @if(empty($cantProductosVendidos))
                        <p class="text-center text-muted">No hay datos disponibles para mostrar este gráfico.</p>
                    @else
                        <div id="chart4"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script>
    const ventasData = JSON.parse('{{ json_encode(array_values($ventas_data)) }}');
    const productosMasVendidos = JSON.parse('{!! json_encode(array_values($cantProductosVendidos)) !!}');
    const porcentajeStockBajo = JSON.parse('{{ json_encode($porcentajeStockBajo) }}');
    const ventasDiarias = JSON.parse('{!! json_encode(array_values($ventasDiarias)) !!}');

    
    //Ventas registradas por mes
    var options = {
        chart: {
            type: 'bar',
            width: 700,
            height: 350
        },
        series: [{
            name: 'Ventas',
            data: ventasData
        }],
        xaxis: {
            categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic']
        }
    }
    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();


    //Productos más vendidos
    var options = {
          series: productosMasVendidos.map(item => Number(item.total_vendidos)),
          chart: {
          width: 380,
          type: 'pie',
        },
        labels: productosMasVendidos.map(item => `${item.nombre}`),
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
    };
    var chart = new ApexCharts(document.querySelector("#chart2"), options);
    chart.render();


    //Productos con bajo stock
    var options = {
        series: [porcentajeStockBajo],
        chart: {
            height: 350,
            type: 'radialBar',
        },
        plotOptions: {
            radialBar: {
                hollow: {
                    size: '60%', // controla el diámetro interno
                },
                track: {
                    margin: 10, // aumenta el margen entre el anillo y el hueco, afinando el espesor
                }
            }
        },
        labels: ['Porcentaje'],
    };
    var chart = new ApexCharts(document.querySelector("#chart3"), options);
    chart.render();


    //Cantidad de productos vendidos por día
    var options = {
        chart: {
            type: 'line',
            width: 600,
            height: 220
        },
        series: [{
            name: 'Ventas Diarias',
            data: ventasDiarias.map(item => item.total)
        }],
        xaxis: {
            categories: ventasDiarias.map(item => item.dia),
            labels: {
                formatter: function (value) {
                    const date = new Date(value + 'T00:00:00');

                    const day = String(date.getDate()).padStart(2, '0');
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const year = date.getFullYear();

                    return `${day}-${month}-${year}`;
                }
            }
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return Math.floor(value);
                }
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#chart4"), options);
    chart.render();
</script>
@endsection