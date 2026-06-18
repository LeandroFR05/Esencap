@foreach ($historial as $h)
    <x-historialInfo 
        :id="'modalHistorial-' . $h->idLote" 
        :titulo="$h->producto->nombre"
        :contenidoPorUnidad="$h->producto->contenidoPorUnidad"
        :stockInicial="$h->stockInicial">

        @foreach ($h->formulas as $f)
            <tr>
                <td>{{ $f->porcentaje }}%</td>
                <td>{{ $f->insumo->familia->nombre }}</td>
                <td>{{ $f->contenido }}gr</td>
                <td>{{ $f->insumo->nombre }}</td>
            </tr>
        @endforeach
    </x-historialInfo>
@endforeach