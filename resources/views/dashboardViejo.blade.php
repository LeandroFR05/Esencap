@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')

    <!--INSUMOS-->
    <a href="{{ route('insumos.create') }}"><i class="bi bi-plus-lg"></i> Nuevo Insumo</a>
    <br>

    <!--LOTES-->
    <a href="{{ route('lotes.infoVencimientos') }}">Lotes próximos a vencerse</a>
    <br>
    <a href="{{ route('lotes.infoStock') }}">Lotes con bajo stock</a>
    <br>
    <a href="{{ route('ventas.index') }}">Vender</a>
    <br>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Ventas registradas por mes</h5>
                </div>
                <div class="card-body">
                    <div id="chart"></div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Productos más vendidos</h5>
                </div>
                <div class="card-body">
                    <div id="chart2"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5>Productos con bajo stock</h5>
                </div>
                <div class="card-body">
                    <div id="chart3"></div>
                </div>
            </div>
        </div>
    </div>

    <br>
        
    <!--CERRAR SESIÓN-->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-danger"><i class="bi bi-box-arrow-left"></i> Cerrar Sesión</button>
    </form>
@endsection


@section('scripts')
<script>
    const ventasData = JSON.parse('{{ json_encode(array_values($ventas_data)) }}');
    const productosVendidos = JSON.parse('{!! json_encode(array_values($cantProductosVendidos)) !!}');
    const porcentajeStockBajo = JSON.parse('{{ json_encode($porcentajeStockBajo) }}');
    
    var options = {
        chart: {
            type: 'bar'
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


    var options = {
          series: productosVendidos.map(item => Number(item.total_vendidos)),
          chart: {
          width: 380,
          type: 'pie',
        },
        labels: productosVendidos.map(item => `${item.nombre}`),
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


    var options = {
          series: [porcentajeStockBajo],
          chart: {
          height: 350,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            hollow: {
              size: porcentajeStockBajo + '%',
            }
          },
        },
        labels: ['Productos'],
    };

    var chart = new ApexCharts(document.querySelector("#chart3"), options);
    chart.render();
</script>
@endsection