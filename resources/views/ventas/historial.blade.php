@extends('layouts.admin')
@section('page', 'Historial de ventas')
@section('title')
    {{ Breadcrumbs::render('ventasHistorial') }}
@endsection

@section('content')

    {{-- Filtros --}}
    @component('components.cards')
        @slot('titulo')
            <i class="bi bi-funnel me-2"></i>Filtros
        @endslot
        @slot('contenido')
            <form method="GET" action="{{ route('ventas.historial') }}" id="formFiltros">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="cliente" class="form-label fw-semibold small">Cliente</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" id="cliente" name="cliente" class="form-control"
                                placeholder="Buscar cliente..." value="{{ request('cliente', '') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
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
                    <div class="col-md-2">
                        <button type="button" class="btn btn-secondary w-100" onclick="limpiarFiltros()">
                            Limpiar
                        </button>
                    </div>
                </div>
            </form>
        @endslot
    @endcomponent

    <br>

    {{-- Tabla --}}
    @component('components.cards')
        @slot('titulo')
            <i class="bi bi-bag-check me-2"></i>Historial de ventas
        @endslot
        @if(!$ventas->isEmpty())
            @slot('bodyClass', 'p-0')
            @slot('contenido')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0"
                        style="table-layout: fixed; width: 100%;"
                        id="tableHistorial">
                        <thead class="table-dark">
                            <tr>
                                <th class="sortable" data-col="0" data-dir="asc" style="width: 180px;">
                                    Fecha <i class="bi bi-arrow-down-up text-secondary ms-1"></i>
                                </th>
                                <th style="width: 180px;">
                                    Usuario
                                </th>
                                <th class="sortable" data-col="1" data-dir="asc">
                                    Cliente <i class="bi bi-arrow-down-up text-secondary ms-1"></i>
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
                </div>
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
