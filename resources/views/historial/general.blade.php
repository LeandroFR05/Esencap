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
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="producto" class="form-label fw-semibold small">Producto</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                        <input type="text" id="producto" class="form-control" placeholder="Buscar producto...">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="fecha" class="form-label fw-semibold small">Fecha</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-calendar-event"></i></span>
                        <input type="date" id="fecha" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
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
            <i class="bi bi-clock-history me-2"></i>Historial de elaboración
        @endslot
        @slot('bodyClass', 'p-0')
        @slot('contenido')
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0" id="tableHistorial">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha</th>
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
                                <td>{{ \Carbon\Carbon::parse($h->fechaElaboracion)->format('d/m/Y') }}</td>
                                <td>{{ $h->producto->nombre }}</td>
                                <td>{{ $h->stockInicial }}u</td>
                                <td>{{ $h->stockActual }}u</td>
                                <td>{{ $h->producto->contenidoPorUnidad }}gr</td>
                                <td>
                                    @php
                                        if ($h->producto->estado == 1) {
                                            echo '<span class="badge bg-success w-100">Activo</span>';
                                        } elseif ($h->producto->estado == 0) {
                                            echo '<span class="badge bg-danger w-100">Eliminado</span>';
                                        } else {
                                            echo $h->producto->estado;
                                        }
                                    @endphp
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
    @endcomponent

    @include('historial.modals.detalle_historial')

@endsection

@section('scripts')
    <script src="{{ asset('js/historial/filtros_historial.js') }}"></script>
    <script src="{{ asset('js/confirmarEliminacion.js') }}"></script>
@endsection