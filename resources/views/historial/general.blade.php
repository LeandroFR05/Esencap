@extends('layouts.admin')
@section('page', 'Historial')
@section('title')
    {{ Breadcrumbs::render('historialGeneral') }}
@endsection
@section('content')

<div class="container">

    <div class="card">
        <div class="card-header">Historial de Elaboración</div>
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
                        <th>Stock inicial</th>
                        <th>Stock actual</th>
                        <th>Contenido por unidad</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historial as $h)
                        <tr>
                            <td>{{ $h->fechaElaboracion }}</td>
                            <td>{{ $h->producto->nombre }}</td>
                            <td>{{ $h->stockInicial }}u</td>
                            <td>{{ $h->stockActual }}u</td>
                            <td>{{ $h->producto->contenidoPorUnidad }}gr</td>
                            <td>
                                <button 
                                    class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalHistorial-{{ $h->idHistorial }}">
                                    Ver fórmula
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@include('historial.modals.detalle_historial')

<div class="d-flex justify-content-center mt-3">
    {{ $historial->links() }}
</div>

@endsection


@section('scripts')
    <script src="{{asset('js/filtros_historiales.js')}}"></script>
@endsection