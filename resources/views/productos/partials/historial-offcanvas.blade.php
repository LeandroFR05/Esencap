<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Historial</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div>
            @if ($producto->historiales->isEmpty())
                <p>No hay historial de elaboraciones para este producto.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Fecha de Elaboración</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($producto->historiales as $historial)
                            <tr>
                                <td>{{ $historial->fechaElaboracion }}</td>
                                <td>{{ $historial->stock }}</td>
                            </tr>

                            <tr>
                                <td colspan="2">
                                    @foreach ($historial->formulas as $formula)
                                        Familia: {{ $formula->familia->nombre }}
                                        Insumo: {{ $formula->insumo->nombre }}
                                        Porcentaje: {{ $formula->porcentaje }}
                                        Contenido: {{ $formula->contenido }}
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>