@extends("layouts.admin")
@section('page', 'Reponer Insumo')
@section("title", "Reponer insumo")
@section("content")
    <form action="{{ route('insumos.reponer.store', $insumo->idInsumo) }}" method="POST">
        @csrf
        <label for="stock">Stock:</label>
        <input type="number" name="stock" required>
        <br>
        <label for="fechaVencimiento">Fecha de vencimiento:</label>
        <input type="date" name="fechaVencimiento" required>
        <br>

        <button type="submit" class="btn btn-success">Reponer</button>
    </form>

    <a href="{{ route('insumos.estante') }}" class="btn btn-danger">Volver atrás</a>

@endsection