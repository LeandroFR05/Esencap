@extends('layouts.admin')
@section('page', 'Lotes')
@section('title')
    {{ Breadcrumbs::render('lotes', $insumo) }}
@endsection

@section('content')

    {{-- Tarjetas de resumen --}}
    <div class="row justify-content-center mb-3">
        <div class="col-xl-10">
            <div class="row g-3">
                <div class="col-sm-6 col-md-4">
                    <div class="card shadow-sm border-0 bg-primary-subtle">
                        <div class="card-body d-flex align-items-center gap-3 py-3">
                            <i class="bi bi-layers fs-2 text-primary"></i>
                            <div>
                                <div class="text-muted small text-uppercase fw-semibold">Lotes registrados</div>
                                <div class="fs-4 fw-bold text-primary">{{ $lote->count() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="card shadow-sm border-0 bg-success-subtle">
                        <div class="card-body d-flex align-items-center gap-3 py-3">
                            <i class="bi bi-box-seam fs-2 text-success"></i>
                            <div>
                                <div class="text-muted small text-uppercase fw-semibold">Stock total</div>
                                <div class="fs-4 fw-bold text-success">
                                    {{ $lote->sum('stockActual') }} {{ $insumo->unidadDeMedida }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @component('components.cards')
        @slot('titulo')
            <i class="bi bi-box-seam me-2"></i>Lotes de {{ $insumo->nombre }}
        @endslot

        @slot('contenido')
        @slot('bodyClass', 'p-0')
            @if($lote->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>N° de Lote</th>
                                <th>Stock inicial</th>
                                <th>Stock actual</th>
                                <th>F. compra</th>
                                <th>F. vencimiento</th>
                                <th class="text-center" style="width: 50px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lote as $item)
                                @php
                                    $vencimiento   = \Carbon\Carbon::parse($item->fechaVencimiento);
                                    $diasRestantes = now()->diffInDays($vencimiento, false);
                                    $badgeClass    = match(true) {
                                        $diasRestantes < 0  => 'danger',
                                        $diasRestantes < 30 => 'warning',
                                        default             => 'success',
                                    };
                                @endphp
                                <tr>
                                    <td class="text-center">
                                        <code class="fw-bold">{{ $item->numeroLote }}</code>
                                    </td>
                                    <td class="text-center">
                                        {{ $item->stockInicial }} {{ $insumo->unidadDeMedida }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-success stock-actual" data-id="{{ $item->idLote }}">
                                            {{ $item->stockActual }} {{ $insumo->unidadDeMedida }}
                                        </span>
                                    </td>
                                    <td class="text-center text-muted small">
                                        {{ \Carbon\Carbon::parse($item->fechaCompra)->format('d/m/Y') }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-{{ $badgeClass }}">
                                            {{ \Carbon\Carbon::parse($item->fechaVencimiento)->format('d/m/Y') }}
                                        </span>
                                    </td>
                                    <td class="p-1">
                                        <form action="{{ route('lotes.destroy', $item->idLote) }}" method="POST" class="w-100">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="idInsumo" value="{{ $insumo->idInsumo }}">
                                            <button type="submit"
                                                class="btn btn-sm btn-danger delete-btn w-100"
                                                title="Eliminar lote">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="table-secondary fw-bold">
                                <td colspan="2" class="text-end text-muted small text-uppercase">
                                    Stock total:
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success">
                                        {{ $lote->sum('stockActual') }} {{ $insumo->unidadDeMedida }}
                                    </span>
                                </td>
                                <td colspan="3"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                    No existen lotes registrados para este insumo.
                </div>
            @endif
        @endslot

        @slot('footer')
            <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    {{ $lote->count() }} lote(s) encontrado(s)
                </small>
                <a href="{{ route('insumos.reponer', $insumo->idInsumo) }}"
                   class="btn btn-success btn-sm">
                    <i class="bi bi-plus-lg me-1"></i>Reponer stock
                </a>
            </div>
        @endslot
    @endcomponent

@endsection

@section('scripts')
    <script src="{{ asset('js/confirmarEliminacion.js') }}"></script>
@endsection