@foreach ($ventas as $v)
    <div class="modal fade" id="modalVenta{{ $v->idVenta }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header text-black" style="background-color: #b3f9b6;">
                    <h5 class="modal-title">
                        <i class="bi bi-receipt me-2"></i>Detalle de Venta #{{ $v->idVenta }}
                    </h5>
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-0">

                    {{-- Datos de la venta --}}
                    <div class="row g-0 border-bottom">
                        <div class="col-6 border-end px-4 py-3">
                            <p class="mb-1 text-muted small text-uppercase fw-semibold">
                                <i class="bi bi-person me-1"></i>Cliente
                            </p>
                            <p class="fw-semibold mb-0">{{ $v->cliente }}</p>
                        </div>
                        <div class="col-6 px-4 py-3">
                            <p class="mb-1 text-muted small text-uppercase fw-semibold">
                                <i class="bi bi-calendar-event me-1"></i>Fecha
                            </p>
                            <p class="fw-semibold mb-0">{{ $v->fecha }}</p>
                        </div>
                    </div>

                    {{-- Tabla de productos --}}
                    <div class="table-responsive px-4 pt-3">
                        <p class="text-muted small text-uppercase fw-semibold mb-2">
                            <i class="bi bi-cart3 me-1"></i>Productos vendidos
                        </p>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center mb-0"
                               style="table-layout: fixed; width: 100%;">
                            <thead class="table-dark">
                                <tr>
                                    <th class="small text-uppercase text-start">Nombre</th>
                                    <th class="small text-uppercase" style="width: 160px;">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($v->carritos as $carrito)
                                    <tr>
                                        <td class="text-start">
                                            @if($carrito->producto)
                                                <span class="fw-medium">{{ $carrito->producto->nombre }}</span>
                                            @else
                                                <span class="text-muted fst-italic">
                                                    <i class="bi bi-slash-circle me-1"></i>Producto eliminado
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $carrito->cantidad }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox fs-4 d-block mb-1 opacity-50"></i>
                                            No hay productos en esta venta
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="table-secondary fw-bold">
                                    <td class="text-end small text-uppercase text-muted">Total unidades:</td>
                                    <td>
                                        <span class="badge bg-success">
                                            {{ $v->carritos->sum('cantidad') }}
                                        </span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>

                <div class="modal-footer bg-light border-top">
                    <small class="text-muted me-auto">
                        <i class="bi bi-bag me-1"></i>
                        {{ $v->carritos->count() }} producto(s) en esta venta
                    </small>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i>Cerrar
                    </button>
                </div>

            </div>
        </div>
    </div>
@endforeach