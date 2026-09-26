<!-- PLANTILLA -->
@extends('layouts.admin')

@section('page', 'Historial de ventas')

@section('title')
    {{ Breadcrumbs::render('ventasHistorial') }}
@endsection

@section('styles')
    @vite('resources/css/Productos/estCreate.css')
    @vite('resources/css/estTablas.css')
@endsection

<!-- CONTENIDO -->
@section('content')
    <form method="GET" action="{{ route('ventas.historial') }}" id="formFiltros">
        @component('components.cards')
            @slot('titulo')
                <i class="bi bi-funnel me-2"></i>Filtros
            @endslot
            @slot('contenido')
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="cliente" class="form-label fw-semibold small">Cliente</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" id="cliente" name="cliente" class="form-control"
                                placeholder="Buscar cliente..." value="{{ request('cliente', '') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="fecha" class="form-label fw-semibold small">Fecha</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" id="fecha" name="fecha" class="form-control"
                                value="{{ request('fecha', '') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="orden" class="form-label fw-semibold small">Ordenar por fecha</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-sort-down"></i></span>
                            <select id="orden" name="orden" class="form-select">
                                <option value="">Sin orden</option>
                                <option value="reciente" @selected(request('orden') === 'reciente')>Más reciente</option>
                                <option value="antigua" @selected(request('orden') === 'antigua')>Más antigua</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-danger w-100" onclick="limpiarFiltros()">
                            <i class="bi bi-trash"></i> Limpiar filtros
                        </button>
                    </div>
                </div>
            @endslot
        @endcomponent
    </form><br>


    @component('components.cards')
        @slot('titulo')
            <i class="bi bi-bag-check me-2"></i>Historial de ventas
        @endslot
        @if(!$ventas->isEmpty())
            @slot('contenido')
                <table id="tableHistorial">
                    <thead>
                        <tr>
                            <th class="sortable" data-col="0" data-dir="asc" style="width: 180px;">
                                Fecha <i class="bi bi-arrow-down-up text-white ms-1"></i>
                            </th>
                            <th style="width: 180px;">
                                Usuario
                            </th>
                            <th class="sortable" data-col="2" data-dir="asc">
                                Cliente <i class="bi bi-arrow-down-up text-white ms-1"></i>
                            </th>
                            <th class="text-center" style="width: 120px;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $v)
                            <tr>
                                <td>{{ $v->fecha }}</td>
                                <td>{{ optional($v->usuario)->name }}</td>
                                <td>{{ $v->cliente }}</td>
                                <td class="p-1">
                                    <button type="button"
                                        class="btn btn-info btn-sm w-100"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalVenta{{ $v->idVenta }}">
                                        <i class="bi bi-eye me-1"></i>Ver
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endslot
            @if($ventas->hasPages())
                @slot('footer')
                    <div class="d-flex justify-content-center">
                        {{ $ventas->links() }}
                    </div>
                @endslot
            @endif
        @else
            @slot('contenido')
                <p class="text-center">No se encontraron resultados.</p>
            @endslot
        @endif
    @endcomponent

    @include('ventas.modals.modal_detalleVenta')

@endsection

@section('scripts')
    <script src="{{ asset('js/ventas/filtros_historial.js') }}"></script>
    <script src="{{ asset('js/ordenarHistorial.js') }}"></script>
@endsection
