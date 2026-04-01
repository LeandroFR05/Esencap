@extends('layouts.admin')
@section('page', 'Lotes')
@section('title')
    {{ Breadcrumbs::render('lotes', $insumo) }}
@endsection
@section('content')

    @component('components.cards')
        @slot('titulo', 'Lotes de ' . $insumo->nombre)

        @slot('contenido')
            @if($lote->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th scope="col" class="fw-semibold">Número de lote</th>
                                <th scope="col" class="fw-semibold">Stock Inicial</th>
                                <th scope="col" class="fw-semibold">Stock Actual</th>
                                <th scope="col" class="fw-semibold">Fecha de compra</th>
                                <th scope="col" class="fw-semibold">Fecha de vencimiento</th>
                                <th scope="col" class="fw-semibold" style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lote as $item)
                                <tr>
                                    <td class="fw-medium">{{ $item->numeroLote }}</td>
                                    <td>{{ $item->stockInicial }} {{ $insumo->unidadDeMedida }}</td>
                                    <td>
                                        <span class="stock-actual" data-id="{{ $item->idLote }}">
                                            {{ $item->stockActual }} {{ $insumo->unidadDeMedida }}
                                        </span>
                                    </td>
                                    <td>{{ $item->fechaCompra }}</td>
                                    <td>{{ $item->fechaVencimiento }}</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-warning edit-stock-btn"
                                                data-id="{{ $item->idLote }}"
                                                data-stock="{{ $item->stockActual }}"
                                                data-unidad="{{ $insumo->unidadDeMedida }}"
                                                data-toggle="tooltip"
                                                title="Modificar stock">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="{{ route('lotes.eliminar', $item->idLote) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="idInsumo" value="{{ $insumo->idInsumo }}">
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger delete-btn"
                                                    data-toggle="tooltip"
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
                                <td colspan="2" class="text-end">Stock Total:</td>
                                <td>{{ $lote->sum('stockActual') }} {{ $insumo->unidadDeMedida }}</td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <h6 style="display: flex; justify-content: center;">No existen lotes para este insumo actualmente</h6>
            @endif
        @endslot

        @slot('footer')
            <div class="d-flex justify-content-end">
                <a href="{{ route('insumos.reponer', $insumo->idInsumo) }}" 
                   class="btn btn-outline-success">
                    <i class="bi bi-plus-lg"></i>
                    Reponer
                </a>
            </div>
        @endslot
    @endcomponent

    <div class="modal fade" id="modalEditarStock" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modificar Stock Actual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEditarStock" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="loteId" name="loteId">
                    <input type="hidden" name="idInsumo" value="{{ $insumo->idInsumo }}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nuevoStock" class="form-label fw-semibold">Stock Actual</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="nuevoStock" name="stockActual" min="0" required>
                                <span class="input-group-text" id="unidadMedida">{{ $insumo->unidadDeMedida }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/lotes/confirmarEliminacion.js') }}"></script>
    <script src="{{ asset('js/lotes/editarStock.js') }}"></script>
@endsection