@foreach($lotesAgrupados as $idInsumo => $lotes)
    <div class="modal fade" id="modalLotes-{{ $lotes->first()->idLote }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $lotes->first()->insumo->nombre }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Lote</th>
                                <th>Stock (gr)</th>
                                <th>Envases</th>
                                <th>Vencimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lotes as $detalleLote)
                                <tr>
                                    <td>{{ $detalleLote->numeroLote }}</td>
                                    <td>{{ $detalleLote->stock }}</td>
                                    <td>{{ number_format($detalleLote->stock / $detalleLote->insumo->contenidoPorUnidad, 2, '.', '') }}</td>
                                    <td>{{ $detalleLote->fechaVencimiento }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach