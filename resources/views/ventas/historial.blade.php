@extends('layouts.admin')
@section('page', 'Historial de ventas')
@section('title')
    {{ Breadcrumbs::render('ventasHistorial') }}
@endsection
@section('content')

<div class="container">

    <div class="card">
        <div class="card-header">Historial de Ventas</div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="producto">Producto</label>
                    <input type="text" id="producto" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-secondary w-100" onclick="limpiarFiltros()">
                        Limpiar Filtros
                    </button>
                </div>
            </div>

            <table class="table table-bordered table-hover" id="tableHistorial">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Cliente</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $v)
                        <tr>
                            <td>{{ $v->fecha }}</td>
                            <td>{{ $v->producto->nombre }}</td>
                            <td>{{ $v->cliente }}</td>
                            <td>{{ $v->cantidad }}u.</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $ventas->links() }}
</div>

@endsection


@section('scripts')
    <script src="{{asset('js/filtros_historiales.js')}}"></script>
@endsection