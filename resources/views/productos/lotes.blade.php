@extends('layouts.admin')
@section('page', 'Lotes de ' . $producto->nombre)

@section('title')
    {{ Breadcrumbs::render('lotesProducto', $producto) }}
@endsection

@section('content')
    {{-- Tarjetas de resumen --}}
    <div class="row justify-content-center mb-3">
        <div class="col-xl-10">
            <div class="row g-3">
                <div class="col-sm-6 col-md-4">
                    <div class="card shadow-sm border-0 bg-primary-subtle">
                        <div class="card-body d-flex align-items-center gap-3 py-3">
                            <i class="bi bi-layers fs-2 text-primary"></i>
                            <div>
                                <div class="text-muted small text-uppercase fw-semibold">Lotes registrados</div>
                                <div class="fs-4 fw-bold text-primary">{{ $lote->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card shadow-sm border-0 bg-success-subtle">
                        <div class="card-body d-flex align-items-center gap-3 py-3">
                            <i class="bi bi-box-seam fs-2 text-success"></i>
                            <div>
                                <div class="text-muted small text-uppercase fw-semibold">Stock total</div>
                                <div class="fs-4 fw-bold text-success">
                                    {{ $lote->sum('stockActual') }} unidades
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @component('components.cards')
        @slot('titulo')
            <i class="bi bi-clock-history me-2"></i>
            Lotes de {{ $producto->nombre }}
        @endslot

        @slot('contenido')
        @slot('bodyClass', 'p-0')
            @if ($producto->lotes->isEmpty())
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
                            @foreach ($producto->lotes as $lote)
                                <tr>
                                    <td class="text-center">
                                        <code class="fw-bold">{{ $lote->numeroLote }}</code>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($lote->fechaElaboracion)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">
                                        {{ $lote->stockInicial }}u
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success">
                                            {{ $lote->stockActual }}u
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
                                                data-bs-target="#modalLoteProd-{{ $lote->idLote }}"
                                                data-toggle="tooltip"
                                                title="Ver detalle"
                                            >
                                                <i class="bi bi-eye-fill"></i>
                                            </button>

                                            <form action="{{ route('loteProducto.destroy', $lote->idLote) }}" method="POST" class="flex-fill">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="idProducto" value="{{ $producto->idProducto }}">
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger delete-btn w-100"
                                                    title="Eliminar lote">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
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
                                        {{ $producto->lotes->sum('stockActual') }}u
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
