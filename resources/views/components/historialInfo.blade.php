<div class="modal fade" id="{{ $id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">

            <div class="modal-header text-black" style="background-color: #b3f9b6;">
                <h5 class="modal-title">
                    <i class="bi bi-journal-text me-2"></i>{{ $titulo }}
                </h5>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body p-0">

                {{-- Encabezado de columnas --}}
                <div class="row text-center g-0 border-bottom bg-light py-2 mx-0">
                    <div class="col-6 border-end">
                        <span class="fw-semibold text-secondary small text-uppercase">
                            <i class="bi bi-file-text me-1"></i>Fórmula Base
                        </span>
                    </div>
                    <div class="col-6">
                        <span class="fw-semibold text-secondary small text-uppercase">
                            <i class="bi bi-calculator me-1"></i>Fórmula Recalculada
                        </span>
                    </div>
                </div>

                {{-- Tabla --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center mb-0" 
                        style="table-layout: fixed; width: 100%;">
                        <thead class="table-dark">
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
                </div>

                {{-- Sección "Calculado sobre" --}}
                <div class="px-4 py-3 border-top bg-light">
                    <p class="text-uppercase text-muted mb-2 small fw-semibold">
                        <i class="bi bi-calculator me-1"></i>Calculado sobre
                    </p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card border shadow-sm h-100">
                                <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">
                                        <i class="bi bi-boxes me-1"></i>Stock inicial
                                    </span>
                                    <div>
                                        <span class="fw-bold fs-5 text-dark">{{ $stockInicial }}</span>
                                        <span class="text-muted small ms-1">unidades</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border shadow-sm h-100">
                                <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">
                                        <i class="bi bi-rulers me-1"></i>Contenido por unidad
                                    </span>
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

            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Cerrar
                </button>
            </div>

        </div>
    </div>
</div>