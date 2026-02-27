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
            <table class="table table-bordered table-hover" id="tableLotes">
                <thead class="table-dark">
                    <tr>
                        <th>Insumo</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lotesAgrupados as $idInsumo => $lotes)
                        <tr>
                            <td>{{ $lotes->first()->insumo->nombre }}</td>
                            <td>
                                <button 
                                    class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalLotes-{{ $lotes->first()->idLote }}">
                                    Ver detalle
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<!--Filtros-->
@section('scripts')
    <script src="{{ asset('js/lotes.js') }}"></script>
@endsection

@include('lotes.modals.detalle_lotes')


