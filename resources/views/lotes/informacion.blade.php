<!-- Estilos -->
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/Lotes/estilosLotes.css') }}">
@endsection



<h3>Filtros:</h3>
<a href="{{ route('lotes.infoStock') }}" class="btn btn-info">Bajo Stock</a>
<a href="{{ route('lotes.infoVencimientos') }}" class="btn btn-info">Próximos Vencimientos</a>

<select name="insumos" id="insumos">
    <option value="todos">Todos</option>
    @foreach($lotesAgrupados as $idInsumo => $lotes)
        <option value="{{ $idInsumo }}">{{ $lotes->first()->insumo->nombre }}</option>
    @endforeach
</select>


@foreach($lotesAgrupados as $idInsumo => $lotes)
<br>
<div class="accordion" id="accordion">
    <!--Traemos los lotes que estan próximos a vencerse, los cuáles están agrupados por idInsumo-->
    
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                data-bs-target="#collapse-{{ $idInsumo }}" aria-expanded="true" aria-controls="collapse-{{ $idInsumo }}">
                    <!--Mostramos el nombre del insumo con first(), para que lo escriba una sola vez-->
                    {{ $lotes->first()->insumo->nombre }}
                </button>
            </h2>
            <div id="collapse-{{ $idInsumo }}" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <table class="table table-striped"> 
                        <thead>
                            <tr class="table-secondary">
                                <th scope="col">Lote</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Vencimiento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--Mostramos los detalles de cada lote perteneciente a ese insumo-->
                            @foreach($lotes as $detalleLote)
                                <tr class="table-danger">
                                    <td>{{ $detalleLote->numeroLote }}</td>
                                    <td>{{ $detalleLote->stock }}</td>
                                    <td>{{ $detalleLote->fechaVencimiento }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>
@endforeach


<!--Filtros-->
@section('scripts')
    <script src="{{ asset('js/lotes.js') }}"></script>
@endsection