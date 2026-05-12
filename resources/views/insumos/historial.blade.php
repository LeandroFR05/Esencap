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
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="insumo" class="form-label fw-semibold small">Insumo</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                        <input type="text" id="insumo" class="form-control" placeholder="Buscar insumo...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="fechaCompra" class="form-label fw-semibold small">Fecha de compra</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        <input type="date" id="fechaCompra" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="fechaVencimiento" class="form-label fw-semibold small">Fecha de vencimiento</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        <input type="date" id="fechaVencimiento" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-secondary w-100" onclick="limpiarFiltros()">
                        Limpiar
                    </button>
                </div>
            </div>
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
                                <th>Fecha de compra</th>
                                <th>Insumo</th>
                                <th>Stock inicial</th>
                                <th>Stock actual</th>
                                <th>Fecha de vencimiento</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lotes as $lote)
                                @if($lote->insumo)
                                    <tr>
                                        <td class="text-center fw-bold"><code>{{ $lote->numeroLote }}</code></td>
                                        <td>{{ $lote->fechaCompra }}</td>
                                        <td>{{ $lote->insumo->nombre }}</td>
                                        <td>{{ $lote->stockInicial }}u</td>
                                        <td>{{ $lote->stockActual }}u</td>
                                        <td>{{ $lote->fechaVencimiento }}</td>
                                        <td>
                                            @if($lote->insumo->estado == 1)
                                                <span class="badge bg-success w-100">Activo</span>
                                            @elseif($lote->insumo->estado == 0)
                                                <span class="badge bg-danger w-100">Eliminado</span>
                                            @else
                                                {{ $lote->insumo->estado }}
                                            @endif
                                        </td>
                                    </tr>
                                @endif
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
@endsection