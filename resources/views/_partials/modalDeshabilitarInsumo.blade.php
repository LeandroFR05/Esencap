<!-- Modal Deshabilitar Insumo -->
<div class="modal fade" id="modalDeshabilitarInsumo" tabindex="-1" aria-labelledby="modalDeshabilitarInsumoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeshabilitarInsumoLabel">Deshabilitar Insumo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('insumos.deshabilitar', $insumo->idInsumo) }}">
                    @csrf
                    @method('PUT')
                    <p>¿Está seguro de que desea deshabilitar este insumo?</p>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Deshabilitar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>