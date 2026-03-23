@foreach ($historial as $h)
    <x-historial 
        :id="'modalHistorial-' . $h->idHistorial" 
        :titulo="$h->producto->nombre"
        :contenidoPorUnidad="$h->producto->contenidoPorUnidad"
        :stockInicial="$h->stockInicial">

        @foreach ($h->formulas as $f)
            <tr>
                <td>{{ $f->porcentaje }}%</td>
                <td>{{ $f->familia->nombre }}</td>
                <td>{{ $f->contenido }}gr</td>
                <td>{{ $f->insumo->nombre }}</td>
            </tr>
        @endforeach
    </x-historial>
@endforeach