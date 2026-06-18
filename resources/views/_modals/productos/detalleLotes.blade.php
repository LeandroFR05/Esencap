@foreach ($producto->lotes as $lote)
    <x-historialInfo 
        :id="'modalLoteProd-' . $lote->idLote" 
        :titulo="$lote->producto->nombre"
        :contenidoPorUnidad="$lote->producto->contenidoPorUnidad"
        :stockInicial="$lote->stockInicial">
        
        @foreach ($lote->formulas as $f)
            <tr>
                <td>{{ $f->porcentaje }}%</td>
                <td>{{ $f->insumo->familia->nombre }}</td>
                <td>{{ $f->contenido }}gr</td>
                <td>{{ $f->insumo->nombre }}</td>
            </tr>
        @endforeach
    </x-historialInfo>
@endforeach