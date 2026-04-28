<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <div class="d-flex flex-wrap align-items-center gap-3">
            <span class="fw-semibold me-2">
                <i class="bi bi-funnel me-1"></i>Filtros:
            </span>
            <a href="{{ route('lotes.infoVencimientos') }}"
               class="btn btn-sm {{ request()->routeIs('lotes.infoVencimientos') ? 'btn-warning' : 'btn-outline-light' }}">
                <i class="bi bi-calendar-x me-1"></i>Próximos vencimientos
            </a>
            <a href="{{ route('lotes.infoStock') }}"
               class="btn btn-sm {{ request()->routeIs('lotes.infoStock') ? 'btn-warning' : 'btn-outline-light' }}">
                <i class="bi bi-exclamation-triangle me-1"></i>Bajo stock
            </a>
            <select name="insumos" id="insumos" class="form-select form-select-sm" style="width: 220px;">
                <option value="todos">Todos los insumos</option>
                @foreach($lotesAgrupados as $idInsumo => $lotes)
                    <option value="{{ $lotes->first()->insumo->nombre }}">
                        {{ $lotes->first()->insumo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="card-body">
        @if($bandera == 1)
            <div class="text-center py-5 text-muted">
                <i class="bi bi-calendar-check fs-1 d-block mb-2 opacity-50"></i>
                No existen lotes próximos a vencerse.
            </div>
        @elseif($bandera == 2)
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                No existen lotes con bajo stock.
            </div>
        @else
            @foreach($lotesAgrupados as $idInsumo => $lotes)
                <div class="card border shadow-sm mb-3" id="cardLotes">
                    <div class="card-header bg-light py-2 px-3 d-flex align-items-center gap-3">
                        <x-foto :foto="$lotes->first()->insumo->foto" />
                        <span class="fw-semibold">{{ $lotes->first()->insumo->nombre }}</span>
                        <span class="badge bg-secondary ms-auto">
                            {{ $lotes->count() }} lote(s)
                        </span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive lotes-scroll">
                            <table class="table table-bordered table-hover align-middle text-center mb-0"
                                   style="table-layout: fixed; width: 100%;">
                                <thead class="table-dark">
                                    <tr>
                                        <th class="small text-uppercase">Lote</th>
                                        <th class="small text-uppercase">Stock inicial</th>
                                        <th class="small text-uppercase">Stock actual</th>
                                        <th class="small text-uppercase">F. compra</th>
                                        <th class="small text-uppercase">F. vencimiento</th>
                                        <th class="small text-uppercase" style="width: 80px;">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lotes as $detalleLote)
                                        @php
                                            $isVencimientosRoute = request()->routeIs('lotes.infoVencimientos');
                                            $isStockRoute        = request()->routeIs('lotes.infoStock');
                                        @endphp
                                        <tr>
                                            <td><code class="fw-bold">{{ $detalleLote->numeroLote }}</code></td>
                                            <td>{{ $detalleLote->stockInicial }} {{ $lotes->first()->insumo->unidadDeMedida }}</td>
                                            <td>
                                                @php
                                                    if($isStockRoute) {
                                                        $stock = $detalleLote->stockActual;
                                                        $badgeStock = match(true) {
                                                            $stock < 0  => 'danger',
                                                            $stock < 30 => 'warning',
                                                            default    => 'success',
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
                                                {{ \Carbon\Carbon::parse($detalleLote->fechaCompra)->format('d/m/Y') }}
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
                                                    {{ \Carbon\Carbon::parse($detalleLote->fechaVencimiento)->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                <form action="{{ route('lotes.eliminar', $detalleLote->idLote) }}" method="POST">
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
                                <tfoot>
                                    <tr class="table-secondary fw-bold">
                                        <td colspan="2" class="text-end text-muted small text-uppercase">Stock total:</td>
                                        <td>
                                            <span class="badge bg-success">
                                                {{ $lotes->sum('stockActual') }} {{ $lotes->first()->insumo->unidadDeMedida }}
                                            </span>
                                        </td>
                                        <td colspan="3"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@section('scripts')
    <script src="{{ asset('js/lotes/filtros.js') }}"></script>
    <script src="{{ asset('js/confirmarEliminacion.js') }}"></script>
@endsection