@foreach ($producto->historiales as $historial)
    <x-historial 
        :id="'modalHistorialProd-' . $historial->idHistorial" 
        :titulo="$historial->producto->nombre">
        
        @foreach ($historial->formulas as $f)
            <tr>
                <td>{{ $f->porcentaje }}%</td>
                <td>{{ $f->familia->nombre }}</td>
                <td>{{ $f->contenido }}gr</td>
                <td>{{ $f->insumo->nombre }}</td>
            </tr>
        @endforeach
    </x-historial>
@endforeach