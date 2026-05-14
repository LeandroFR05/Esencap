@extends('layouts.admin')
@section('page', 'Historial')
@section('title')
    {{ Breadcrumbs::render('historialGeneral') }}
@endsection

@section('content')

    {{-- Filtros --}}
    @component('components.cards')
        @slot('titulo')
            <i class="bi bi-funnel me-2"></i>Filtros
        @endslot
        @slot('contenido')
            <form method="GET" action="{{ route('productos.historial') }}" id="formFiltros">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="producto" class="form-label fw-semibold small">Producto</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                            <input type="text" id="producto" name="producto" class="form-control" 
                                placeholder="Buscar producto..." value="{{ request('producto', '') }}">
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
            <i class="bi bi-clock-history me-2"></i>Historial de productos
        @endslot
        @if(!$historial->isEmpty())
            @slot('bodyClass', 'p-0')
            @slot('contenido')
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0" id="tableHistorial">
                        <thead class="table-dark">
                            <tr>
                                <th>Lote</th>
                                <th>Fecha de elaboración</th>
                                <th>Producto</th>
                                <th>Stock inicial</th>
                                <th>Stock actual</th>
                                <th>Contenido por unidad</th>
                                <th>Estado</th>
                                <th class="text-center" style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($historial as $h)
                                <tr>
                                    <td class="text-center fw-bold"><code>{{ $h->numeroLote }}</code></td>
                                    <td>{{ $h->fechaElaboracion }}</td>
                                    <td>{{ $h->producto->nombre }}</td>
                                    <td>{{ $h->stockInicial }}u</td>
                                    <td>{{ $h->stockActual }}u</td>
                                    <td>{{ $h->producto->contenidoPorUnidad }}gr</td>
                                    <td>
                                        @if ($h->estado == 1 && $h->producto->estado == 1)
                                            <span class="badge bg-success w-100">Activo</span>
                                        @elseif ($h->estado == 0 || $h->producto->estado == 0)
                                            <span class="badge bg-danger w-100">Eliminado</span>
                                        @else
                                            <span class="badge bg-secondary w-100">{{ $h->producto->estado }}</span>
                                        @endif
                                    </td>
                                    <td class="p-1">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <button
                                                class="btn btn-sm btn-primary flex-fill"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHistorial-{{ $h->idHistorial }}">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endslot
            @if($historial->hasPages())
                @slot('footer')
                    <div class="d-flex justify-content-center">
                        {{ $historial->links() }}
                    </div>
                @endslot
            @endif
        @else
            @slot('contenido')
                <p class="text-center">No se encontraron resultados.</p>
            @endslot
        @endif
    @endcomponent

    @include('_modals.productos.detalleHistorial')

@endsection

@section('scripts')
    <script src="{{ asset('js/historial/filtrosHistorial.js') }}"></script>
    <script src="{{ asset('js/confirmarEliminacion.js') }}"></script>
@endsection