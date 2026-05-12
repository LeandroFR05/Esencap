@foreach ($producto->historiales as $historial)
    <x-historialInfo 
        :id="'modalHistorialProd-' . $historial->idHistorial" 
        :titulo="$historial->producto->nombre"
        :contenidoPorUnidad="$historial->producto->contenidoPorUnidad"
        :stockInicial="$historial->stockInicial">
        
        @foreach ($historial->formulas as $f)
            <tr>
                <td>{{ $f->porcentaje }}%</td>
                <td>{{ $f->familia->nombre }}</td>
                <td>{{ $f->contenido }}gr</td>
                <td>{{ $f->insumo->nombre }}</td>
            </tr>
        @endforeach
    </x-historialInfo>
@endforeach