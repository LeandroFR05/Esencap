@extends("layouts.admin")
@section('page', 'Reponer Insumo')
@section("content")

    @component('components.cards')
        @slot('titulo', 'Reponer Insumo')

        @slot('contenido')
            <form action="{{ route('insumos.reponer.store', $insumo->idInsumo) }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-12">
                        <label for="stock">Stock:</label>
                        <input type="number" name="stock" class="form-control" required>
                        <div class="mt-3">
                            <label for="fechaVencimiento">Fecha de vencimiento:</label>
                            <input type="date" name="fechaVencimiento" class="form-control" required>
                        </div>
                    </div>
                </div>
        @endslot
        
        @slot('footer')
            <div class="row g-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success w-100">Reponer</button>
                </div>
            </div>
            </form>
        @endslot
    @endcomponent

@endsection