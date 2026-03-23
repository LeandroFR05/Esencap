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
                        <p>Calculado sobre:</p>

                        <div class="d-flex align-items-center mb-2">
                            <label class="me-2 mb-0" style="width: 140px;">
                                Stock inicial:
                            </label>

                            <input type="number"
                                value="{{ $stockInicial }}"
                                class="form-control form-control-sm"
                                style="width: 90px;"
                                readonly>
                        </div>

                        <div class="d-flex align-items-center mb-2">
                            <label class="me-2 mb-0" style="width: 140px;">
                                Contenido por unidad:
                            </label>

                            <input type="number"
                                value="{{ $contenidoPorUnidad }}"
                                class="form-control form-control-sm"
                                style="width: 90px;"
                                readonly>
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