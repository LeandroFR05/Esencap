@extends("layouts.app")

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

        <button type="submit">Reponer</button>
    </form>
@endsection