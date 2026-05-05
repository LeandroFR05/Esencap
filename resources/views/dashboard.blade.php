@extends('layouts.admin')
@section('page', 'Inicio')
@section('title')
    {{ Breadcrumbs::render('home') }}
@endsection


@section('content')
    <div class="row">
        {{-- Lotes próximos a vencer --}}
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>{{ $lotesProximosaVencer }}</h3>
                    <p>Lotes próximos a vencerse</p>
                </div>

                <i class="bi bi-clock-history small-box-icon"></i>

                <a href="{{ route('lotes.infoVencimientos') }}"
                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                    Ver más 
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Lotes con bajo stock --}}
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-danger">
                <div class="inner">
                    <h3>{{ $lotesBajoStock }}</h3>
                    <p>Lotes con bajo stock</p>
                </div>

                <i class="bi bi-exclamation-circle small-box-icon"></i>

                <a href="{{ route('lotes.infoStock') }}"
                class="small-box-footer link-light link-underline-opacity-0">
                    Ver más
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Insumos registrados --}}
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">

                <div class="inner">
                    <h3>{{ $insumosRegistrados }}</h3>
                    <p>Insumos registrados</p>
                </div>

                <i class="bi bi-box-seam small-box-icon"></i>

                <a href="{{ route('insumos.estante') }}"
                class="small-box-footer link-light link-underline-opacity-0">
                    Ver más
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        {{-- Productos registrados --}}
        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-info">

                <div class="inner">
                    <h3>{{ $productosRegistrados }}</h3>
                    <p>Productos registrados</p>
                </div>

                <i class="bi bi-bag-check small-box-icon"></i>

                <a href="{{ route('productos.estante') }}"
                class="small-box-footer link-light link-underline-opacity-0">
                    Ver más
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row">
        <div class="col-md-8 mb-4">
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
            <div class="card" style="height: 94.7%; width: 100%;">
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
            <div class="card" style="height: 96%;">
                <div class="card-header">
                    <h5>Cantidad de productos vendidos por día</h5>
                </div>
                <div class="card-body">
                    @if(empty($ventasDiarias))
                        <p class="text-center text-muted">No hay datos disponibles para mostrar este gráfico.</p>
                    @else
                        <div id="chart4"></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <!-- Apexcharts -->
    <!-- <script src="{{asset('assets/extensions/apexcharts/apexcharts.min.js')}}"></script> -->
@endsection

@section('scripts')
<!-- apexcharts -->
    <script
      src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js"
      integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8="
      crossorigin="anonymous"
    ></script>
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
        const chartEl = document.querySelector("#chart");
        if (chartEl) {
            const chart = new ApexCharts(chartEl, options);
            chart.render();
        }


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
        const chartEl2 = document.querySelector("#chart2");
        if (chartEl2) {
            const chart = new ApexCharts(chartEl2, options);
            chart.render();
        }


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
        const chartEl3 = document.querySelector("#chart3");
        if (chartEl3) {
            const chart = new ApexCharts(chartEl3, options);
            chart.render();
        }


        //Cantidad de productos vendidos por día
        var options = {
            chart: {
                type: 'line',
                width: 600,
                height: 220
            },
            series: [{
                name: 'Productos vendidos',
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
        const chartEl4 = document.querySelector("#chart4");
        if (chartEl4) {
            const chart = new ApexCharts(chartEl4, options);
            chart.render();
        }
    </script>
@endsection
