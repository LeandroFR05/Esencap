@extends('layouts.admin')
@section('page', 'Historial')
@section('title')
    {{ Breadcrumbs::render('historialInsumos') }}
@endsection

@section('content')

    {{-- Filtros --}}
    @component('components.cards')
        @slot('titulo')
            <i class="bi bi-funnel me-2"></i>Filtros
        @endslot
        @slot('contenido')
            <form method="GET" action="{{ route('insumos.historial') }}" id="formFiltros">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="insumo" class="form-label fw-semibold small">Insumo</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                            <input type="text" id="insumo" name="insumo" class="form-control" 
                                placeholder="Buscar insumo..." value="{{ request('insumo', '') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="fechaCompra" class="form-label fw-semibold small">Fecha de compra</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" id="fechaCompra" name="fechaCompra" class="form-control"
                                value="{{ request('fechaCompra', '') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="fechaVencimiento" class="form-label fw-semibold small">Fecha de vencimiento</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                            <input type="date" id="fechaVencimiento" name="fechaVencimiento" class="form-control"
                                value="{{ request('fechaVencimiento', '') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="estado" class="form-label fw-semibold small">Estado</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-flag"></i></span>
                            <select id="estado" name="estado" class="form-select">
                                <option value="">Todos</option>
                                <option value="Activo">Activo</option>
                                <option value="Eliminado">Eliminado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Buscar
                        </button>
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
            <i class="bi bi-clock-history me-2"></i>Historial de insumos
        @endslot
        @if(!$lotes->isEmpty())
            @slot('bodyClass', 'p-0')
            @slot('contenido')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0" id="tableHistorial">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 80px;">Lote</th>
                                <th class="sortable" data-col="1" data-dir="asc">
                                    Fecha de compra <i class="bi bi-arrow-down-up text-secondary ms-1"></i>
                                </th>
                                <th class="sortable" data-col="2" data-dir="asc">
                                    Insumo <i class="bi bi-arrow-down-up text-secondary ms-1"></i>
                                </th>
                                <th class="sortable" data-col="3" data-dir="asc">
                                    Stock inicial <i class="bi bi-arrow-down-up text-secondary ms-1"></i>
                                </th>
                                <th class="sortable" data-col="4" data-dir="asc">
                                    Stock actual <i class="bi bi-arrow-down-up text-secondary ms-1"></i>
                                </th>
                                <th class="sortable" data-col="5" data-dir="asc">
                                    Fecha de vencimiento <i class="bi bi-arrow-down-up text-secondary ms-1"></i>
                                </th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lotes as $lote)
                                <tr>
                                    <td class="text-center fw-bold"><code>{{ $lote->numeroLote }}</code></td>
                                    <td>{{ $lote->fechaCompra }}</td>
                                    <td>{{ $lote->insumo->nombre }}</td>
                                    <td>{{ $lote->stockInicial }}u</td>
                                    <td>{{ $lote->stockActual }}u</td>
                                    <td>{{ $lote->fechaVencimiento }}</td>
                                    <td>
                                        @if($lote->estado == 1 && $lote->insumo->estado == 1)
                                            <span class="badge bg-success w-100">Activo</span>
                                        @elseif($lote->estado == 0 || $lote->insumo->estado == 0)
                                            <span class="badge bg-danger w-100">Eliminado</span>
                                        @else
                                            {{ $lote->insumo->estado }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endslot
            @if($lotes->hasPages())
                @slot('footer')
                    <div class="d-flex justify-content-center">
                        {{ $lotes->links() }}
                    </div>
                @endslot
            @endif
        @else
            @slot('contenido')
                <p class="text-center">No se encontraron resultados.</p>
            @endslot
        @endif
    @endcomponent
@endsection

@section('scripts')
    <script src="{{ asset('js/insumos/filtrosHistorial.js') }}"></script>
    <script src="{{ asset('js/ordenarHistorial.js') }}"></script>
@endsection