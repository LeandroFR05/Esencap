@extends("layouts.admin")
@section('page', 'Reponer Insumo')
@section("content")

    @component('_components.cards')
        @slot('titulo', 'Reponer Insumo')

        @slot('contenido')
            <form action="{{ route('insumos.reponer.store', $insumo->idInsumo) }}" method="POST">
                @csrf
                <div class="mb-3" style="max-width: 600px; margin: auto;">
                    <label for="stock">Stock:</label>
                    <input type="number" name="stock" class="form-control" required>
                    <br>
                    <label for="fechaVencimiento">Fecha de vencimiento:</label>
                    <input type="date" name="fechaVencimiento" class="form-control" required>
                    <br>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">Reponer</button>
                    </div>
                </div>
            </form>
        @endslot
        
        @slot('footer')
            <a href="{{ route('insumos.estante') }}" class="btn btn-danger">Volver atrás</a>
        @endslot
    @endcomponent

@endsection