<link rel="stylesheet" href="{{ asset('css/Lotes/scroll.css') }}">

<div class="card">
    <div class="card-header">
        <h5>Filtros:</h5>
        <div class="row align-items-center g-3">
            <div class="col-auto">
                <a href="{{ route('lotes.infoStock') }}" 
                class="btn {{ request()->routeIs('lotes.infoStock') ? 'btn-info' : 'btn-outline-info' }}">Bajo Stock</a>
            </div>
            <div class="col-auto">
                <a href="{{ route('lotes.infoVencimientos') }}" 
                class="btn {{ request()->routeIs('lotes.infoVencimientos') ? 'btn-info' : 'btn-outline-info' }}">Próximos Vencimientos</a>
            </div>
            <div class="col-auto">
                <select name="insumos" id="insumos" class="form-select" style="width: 250px; margin-top: 23px;">
                    <option value="todos">Todos</option>
                    @foreach($lotesAgrupados as $idInsumo => $lotes)
                        <option value="{{ $lotes->first()->insumo->nombre }}">{{ $lotes->first()->insumo->nombre }}</option>
                    @endforeach
                </select><br>
            </div>
        </div>
    </div>

    <div class="card-body">
        @if($bandera == 1)
            <h6 style="display: flex; justify-content: center;">No existen lotes próximos a vencerse</h6>
        @elseif($bandera == 2)
            <h6 style="display: flex; justify-content: center;">No existen lotes con bajo stock</h6>
        @else
            @foreach($lotesAgrupados as $idInsumo => $lotes)
                <div class="card mb-4 shadow-lg" id="cardLotes">
                    <div class="card-body">

                        <div class="row">

                            <!-- Imagen -->
                            <div class="col-md-2 text-center">
                                <x-foto :foto="$lotes->first()->insumo->foto" />
                                    
                                <h6 class="mt-2">{{ $lotes->first()->insumo->nombre }}</h6>
                            </div>

                            <!-- Lista de lotes -->
                            <div class="col-md-10">
                                <table class="table table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>Lote</th>
                                            <th>Stock inicial</th>
                                            <th>Stock actual</th>
                                            <th>Fecha de compra</th>
                                            <th>Fecha de vencimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div class="lotes-scroll">
                                            @foreach($lotes as $detalleLote)
                                                <tr>
                                                    <td>{{ $detalleLote->numeroLote }}</td>
                                                    <td>{{ $detalleLote->stockInicial }}{{ $lotes->first()->insumo->unidadDeMedida }}</td>
                                                    <td>{{ $detalleLote->stockActual }}{{ $lotes->first()->insumo->unidadDeMedida }}</td>
                                                    <td>{{ $detalleLote->fechaCompra }}</td>
                                                    <td>{{ $detalleLote->fechaVencimiento }}</td>
                                                </tr>
                                            @endforeach
                                        </div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

<!--Filtros-->
@section('scripts')
    <script src="{{ asset('js/lotes.js') }}"></script>
@endsection
