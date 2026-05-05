@extends("layouts.admin")
@section('page', 'Reponer Insumo')
@section('title')
    {{ Breadcrumbs::render('reponerInsumo', $insumo) }}
@endsection

@section("content")

    @component('components.cards')
        @slot('titulo')
            <i class="bi bi-plus-circle me-2"></i>Reponer {{ $insumo->nombre }}
        @endslot

        @slot('contenido')
            <form id="form-reponer" action="{{ route('insumos.reponer.store', $insumo->idInsumo) }}" method="POST">
                @csrf
                <div class="row g-3">

                    <div class="col-md-6">
                        <label for="numeroLote" class="form-label fw-semibold">Número de lote</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-hash"></i></span>
                            <input type="number" name="numeroLote" id="numeroLote"
                                   value="{{ $nuevoNumero }}" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="stockInicial" class="form-label fw-semibold">Stock inicial</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-boxes"></i></span>
                            <input type="number" name="stockInicial" id="stockInicial"
                                   class="form-control" required>
                            <span class="input-group-text">{{ $insumo->unidadDeMedida }}</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="fechaCompra" class="form-label fw-semibold">Fecha de compra</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-plus"></i></span>
                            <input type="date" name="fechaCompra" id="fechaCompra"
                                   class="form-control @error('fechaCompra') is-invalid @enderror" required>
                            @error('fechaCompra')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="fechaVencimiento" class="form-label fw-semibold">Fecha de vencimiento</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-x"></i></span>
                            <input type="date" name="fechaVencimiento" id="fechaVencimiento"
                                   class="form-control @error('fechaVencimiento') is-invalid @enderror" required>
                            @error('fechaVencimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
            </form>
        @endslot

        @slot('footer')
            <div class="row g-4">
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" form="form-reponer" class="btn btn-success">
                        <i class="bi bi-floppy me-1"></i> Guardar
                    </button>
                </div>
            </div>
        @endslot
    @endcomponent

@endsection