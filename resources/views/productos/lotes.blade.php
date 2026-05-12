@extends('layouts.admin')
@section('page', 'Lotes de ' . $producto->nombre)

@section('title')
    {{ Breadcrumbs::render('lotesProducto', $producto) }}
@endsection

@section('content')
    @component('components.cards')
        @slot('titulo')
            <i class="bi bi-clock-history me-2"></i>
            Lotes de {{ $producto->nombre }}
        @endslot

        @slot('contenido')
        @slot('bodyClass', 'p-0')
            @if ($producto->historiales->isEmpty())
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    No hay lotes para este producto.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0"
                        style="table-layout: fixed; width: 100%;"
                        id="tableHistorial">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th class="fw-semibold">
                                    N° de Lote
                                </th>
                                <th class="fw-semibold">
                                    Fecha de Elaboración
                                </th>
                                <th class="fw-semibold">
                                    Stock inicial
                                </th>
                                <th class="fw-semibold">
                                    Stock actual
                                </th>
                                <th class="fw-semibold">
                                    Contenido por unidad
                                </th>
                                <th class="fw-semibold" style="width: 100px;">
                                    Acciones
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($producto->historiales as $historial)
                                <tr>
                                    <td class="text-center">
                                        <code class="fw-bold">{{ $historial->numeroLote }}</code>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($historial->fechaElaboracion)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">
                                        {{ $historial->stockInicial }}u
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">
                                            {{ $historial->stockActual }}u
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ $producto->contenidoPorUnidad }}gr
                                    </td>
                                    <td class="p-1">
                                        <div class="d-flex gap-1 justify-content-center">
                                            <!-- Ver detalle -->
                                            <button
                                                class="btn btn-sm btn-primary flex-fill"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHistorialProd-{{ $historial->idHistorial }}"
                                                data-toggle="tooltip"
                                                title="Ver detalle"
                                            >
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <tr class="table-secondary fw-bold">
                                <td colspan="2" class="text-end">
                                    Stock Total:
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">
                                        {{ $producto->historiales->sum('stockActual') }}u
                                    </span>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @endif
        @endslot

        @slot('footer')
            <div class="d-flex justify-content-end">
                <a href="{{ route('productos.reponer', $producto->idProducto) }}" class="btn btn-success">
                    <i class="bi bi-plus-lg me-1"></i>
                    Reponer
                </a>
            </div>
        @endslot
    @endcomponent

    @include('_modals.productos.detalleLotes')

@endsection

@section('scripts')
    <script src="{{ asset('js/confirmarEliminacion.js') }}"></script>
@endsection
