@extends("layouts.admin")
@section('page', 'Reponer Insumo')
@section('title')
    {{ Breadcrumbs::render('reponerInsumo', $insumo) }}
@endsection

@section("content")

    @component('components.cards')
        @slot('titulo', 'Reponer ' . $insumo->nombre)

        @slot('contenido')
            <form action="{{ route('insumos.reponer.store', $insumo->idInsumo) }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-12">
                        <label for="numeroLote">Lote número:</label>
                        <input type="number" name="numeroLote" value="{{ $nuevoNumero }}" class="form-control" readonly>
                        <div class="mt-3">
                            <label for="stockInicial">Stock Inicial:</label>
                            <div class="input-group">
                                <input type="number" name="stockInicial" class="form-control" required>
                                <span class="input-group-text w-25 d-flex justify-content-center">{{ $insumo->unidadDeMedida }}</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="fechaCompra">Fecha de compra:</label>
                            <input type="date" name="fechaCompra" class="form-control @error('fechaCompra') is-invalid @enderror" required>
                        </div>
                        <div class="mt-3">
                            <label for="fechaVencimiento">Fecha de vencimiento:</label>
                            <input type="date" name="fechaVencimiento" class="form-control @error('fechaVencimiento') is-invalid @enderror" required>
                        </div>
                    </div>
                </div>
        @endslot
        
        @slot('footer')
            <div class="row g-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success w-100">Guardar</button>
                </div>
            </div>
            </form>
        @endslot
    @endcomponent

@endsection