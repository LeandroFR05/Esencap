@foreach ($ventas as $v)
    <div class="modal fade" id="modalVenta{{ $v->idVenta }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-receipt me-2"></i>Detalle de Venta #{{ $v->idVenta }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Cliente</p>
                            <p class="fw-semibold mb-0">{{ $v->cliente }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1 text-muted small">Fecha</p>
                            <p class="fw-semibold mb-0">{{ $v->fecha }}</p>
                        </div>
                    </div>

                    <h6 class="fw-semibold mb-3">Productos vendidos</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nombre</th>
                                    <th style="width: 120px;">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($v->carritos as $carrito)
                                    <tr>
                                        <td>
                                            @if($carrito->producto)
                                                <span class="fw-medium">{{ $carrito->producto->nombre }}</span>
                                            @else
                                                <span class="text-muted">Producto eliminado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $carrito->cantidad }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted py-3">
                                            No hay productos en esta venta
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <th>Total</th>
                                    <th>
                                        <span class="badge bg-success">{{ $v->carritos->sum('cantidad') }}</span>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach