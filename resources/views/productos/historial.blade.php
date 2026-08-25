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
                    <div class="col-md-4">
                        <label for="estado" class="form-label fw-semibold small">Estado</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-flag"></i></span>
                            <select id="estado" name="estado" class="form-select">
                                <option value="">Todos</option>
                                <option value="Activo" @selected(request('estado') === 'Activo')>Activo</option>
                                <option value="Eliminado" @selected(request('estado') === 'Eliminado')>Eliminado</option>
                            </select>
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
                                <th class="sortable" data-col="1" data-dir="asc">
                                    Fecha de elaboración <i class="bi bi-arrow-down-up text-secondary ms-1"></i>
                                </th>
                                <th class="sortable" data-col="2" data-dir="asc">
                                    Producto <i class="bi bi-arrow-down-up text-secondary ms-1"></i>
                                </th>
                                <th class="sortable" data-col="3" data-dir="asc">
                                    Stock inicial <i class="bi bi-arrow-down-up text-secondary ms-1"></i>
                                </th>
                                <th class="sortable" data-col="4" data-dir="asc">
                                    Stock actual <i class="bi bi-arrow-down-up text-secondary ms-1"></i>
                                </th>
                                <th class="sortable" data-col="5" data-dir="asc">
                                    Contenido por unidad <i class="bi bi-arrow-down-up text-secondary ms-1"></i>
                                </th>
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
                                        @if ($h->estado == 1)
                                            <span class="badge bg-success w-100">Activo</span>
                                        @elseif ($h->estado == 0)
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
                                                data-bs-target="#modalHistorial-{{ $h->idLote }}">
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
    <script src="{{ asset('js/ordenarHistorial.js') }}"></script>
@endsection