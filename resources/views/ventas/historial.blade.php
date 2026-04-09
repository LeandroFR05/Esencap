@extends('layouts.admin')
@section('page', 'Historial de ventas')
@section('title')
    {{ Breadcrumbs::render('ventasHistorial') }}
@endsection
@section('content')

<div class="container">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span class="mb-0">Historial de Ventas</span>
        </div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="cliente">Cliente</label>
                    <input type="text" id="cliente" class="form-control">
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
                        <th style="width: 150px;">Fecha</th>
                        <th>Cliente</th>
                        <th style="width: 120px;">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ventas as $v)
                        <tr>
                            <td>{{ $v->fecha }}</td>
                            <td>{{ $v->cliente }}</td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm w-100" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalVenta{{ $v->idVenta }}">
                                    <i class="bi bi-eye"></i> Ver
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @include('ventas.modals.modal_detalleVenta')
            
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $ventas->links() }}
</div>

@endsection


@section('scripts')
    <script src="{{asset('js/ventas/filtros_historial.js')}}"></script>
@endsection
