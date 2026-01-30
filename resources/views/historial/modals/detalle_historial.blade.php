@foreach ($historial as $h)
    <div class="modal fade" id="modalHistorial-{{ $h->idHistorial }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $h->producto->nombre }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>


                <div class="modal-body">

                    <div class="row">
                        <div class="col">
                            <label for="formulaBase" class="form-label">Formula Base</label>
                        </div>
                        <div class="col">
                            <label for="formulaRecalculada" class="form-label">Formula Recalculada</label>
                        </div>
                    </div>

                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Porcentaje</th>
                                <th>Familia</th>
                                <th>Contenido</th>
                                <th>Insumo</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($h->formulas as $f)
                                <tr>
                                    <td>{{ $f->porcentaje }}</td>
                                    <td>{{ $f->familia->nombre }}</td>
                                    <td>{{ $f->contenido }}</td>
                                    <td>{{ $f->insumo->nombre }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>

            </div>
        </div>
    </div>
@endforeach