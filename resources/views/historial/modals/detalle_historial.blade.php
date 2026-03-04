@foreach ($historial as $h)
    <x-historial 
        :id="'modalHistorial-' . $h->idHistorial" 
        :titulo="$h->producto->nombre">

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