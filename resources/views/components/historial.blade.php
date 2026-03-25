<div class="modal fade" id="{{ $id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $titulo }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <!-- Encabezado de columnas -->
                    <div class="row text-center mb-3">
                        <div class="col-6 border-end">
                            <h6 class="fw-semibold text-secondary mb-0">
                                Fórmula Base
                            </h6>
                        </div>
                        <div class="col-6">
                            <h6 class="fw-semibold text-secondary mb-0">
                                Fórmula Recalculada
                            </h6>
                        </div>
                    </div>

                    <!-- Separador -->
                    <hr class="mt-0 mb-3">

                    <!-- Tabla -->
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center"
                            style="table-layout: fixed; width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th class="small text-uppercase">Porcentaje</th>
                                    <th class="small text-uppercase">Familia</th>
                                    <th class="small text-uppercase">Contenido</th>
                                    <th class="small text-uppercase">Insumo</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{ $slot }}
                            </tbody>
                        </table>

                        <div class="mt-4 pt-2 border-top">
                            <h6 class="text-uppercase text-muted mb-3 small fw-semibold">
                                <i class="bi bi-calculator me-2"></i>Calculado sobre
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body py-2 px-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Stock inicial</span>
                                                <div>
                                                    <span class="fw-bold fs-5 text-dark">{{ $stockInicial }}</span>
                                                    <span class="text-muted small ms-1">unidades</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 bg-light">
                                        <div class="card-body py-2 px-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-muted small">Contenido por unidad</span>
                                                <div>
                                                    <span class="fw-bold fs-5 text-dark">{{ $contenidoPorUnidad }}</span>
                                                    <span class="text-muted small ms-1">gramos</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>