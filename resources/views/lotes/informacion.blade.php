<link rel="stylesheet" href="{{ asset('css/Lotes/scroll.css') }}">

@section('content')
    @component('components.cards')
        @slot('titulo')
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="fw-semibold me-2">
                    <i class="bi bi-funnel me-1"></i>Filtros:
                </span>
                <a href="{{ route('lotes.infoVencimientos') }}"
                class="btn btn-sm {{ request()->routeIs('lotes.infoVencimientos') ? 'btn-warning' : 'btn-outline-warning' }}">
                    <i class="bi bi-calendar-x me-1"></i>Próximos vencimientos
                </a>
                <a href="{{ route('lotes.infoStock') }}"
                class="btn btn-sm {{ request()->routeIs('lotes.infoStock') ? 'btn-warning' : 'btn-outline-warning' }}">
                    <i class="bi bi-exclamation-triangle me-1"></i>Bajo stock
                </a>
                <select name="insumos" id="insumos" class="form-select form-select-sm ms-auto" style="width: 220px;">
                    <option value="todos">Todos los insumos</option>
                    @foreach($lotesAgrupados as $idInsumo => $lotes)
                        <option value="{{ $lotes->first()->insumo->nombre }}">
                            {{ $lotes->first()->insumo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endslot

        @slot('contenido')
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
                                    <div class="lotes-scroll">
                                        <table class="table table-sm table-striped" style="table-layout: fixed; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width: 7%;">Lote</th>
                                                    <th style="width: 20%;">Stock inicial</th>
                                                    <th style="width: 20%;">Stock actual</th>
                                                    <th style="width: 20%;">Fecha de compra</th>
                                                    <th>Fecha de vencimiento</th>
                                                    <th style="width: 7%;">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($lotes as $detalleLote)
                                                    @php
                                                        $isVencimientosRoute = request()->routeIs('lotes.infoVencimientos');
                                                        $isStockRoute        = request()->routeIs('lotes.infoStock');
                                                    @endphp
                                                    <tr>
                                                        <td class="text-center"><code class="fw-bold">{{ $detalleLote->numeroLote }}</code></td>
                                                        <td>{{ $detalleLote->stockInicial }} {{ $lotes->first()->insumo->unidadDeMedida }}</td>
                                                        <td>
                                                            @php
                                                                if($isStockRoute) {
                                                                    $stock = $detalleLote->stockActual;
                                                                    $badgeStock = match(true) {
                                                                        $stock == 0  => 'danger',
                                                                        $stock < 500 => 'warning',
                                                                        default      => 'success',
                                                                    };
                                                                } else {
                                                                    $badgeStock = 'secondary';
                                                                }
                                                            @endphp
                                                            <span class="badge bg-{{ $badgeStock }}">
                                                                {{ $detalleLote->stockActual }} {{ $lotes->first()->insumo->unidadDeMedida }}
                                                            </span>
                                                        </td>
                                                        <td class="text-muted small">
                                                            {{ $detalleLote->fechaCompra }}
                                                        </td>
                                                        <td>
                                                            @php
                                                                if($isVencimientosRoute) {
                                                                    $dias = now()->diffInDays(\Carbon\Carbon::parse($detalleLote->fechaVencimiento), false);
                                                                    $badgeVenc = match(true) {
                                                                        $dias < 0  => 'danger',
                                                                        $dias < 30 => 'warning',
                                                                        default    => 'success',
                                                                    };
                                                                } else {
                                                                    $badgeVenc = 'secondary';
                                                                }
                                                            @endphp
                                                            <span class="badge bg-{{ $badgeVenc }}">
                                                                {{ $detalleLote->fechaVencimiento }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">
                                                            <form action="{{ route('lotes.destroy', $detalleLote->idLote) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="idInsumo" value="{{ $lotes->first()->insumo->idInsumo }}">
                                                                <button type="submit" class="btn btn-sm btn-danger delete-btn" title="Eliminar lote">
                                                                    <i class="bi bi-trash3-fill"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        @endslot
    @endcomponent
    <br>
    <div class="d-flex justify-content-center">
        {{ $insumos->links() }}
    </div>
@endsection

<!--Filtros-->
@section('scripts')
    <script src="{{ asset('js/lotes/filtros.js') }}"></script>
    <script src="{{ asset('js/confirmarEliminacion.js') }}"></script>
@endsection
