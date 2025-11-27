@extends('layouts.app')

@section('title', 'Nuevo producto')
@section('content')
    <h1>Crear Nuevo Producto</h1>

    <form method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
            <br>
            <label for="foto">Foto:</label>
            <input type="file" name="foto">
            <br>
            <label for="stock">Stock:</label>
            <input type="number" name="stock" required>
            <br>
            <label for="contenidoPorUnidad">Contenido por Unidad:</label>
            <input type="number" name="contenidoPorUnidad" required>
            <br>
            <label for="fechaElaboracion">Fecha de Elaboración:</label>
            <input type="date" name="fechaElaboracion" required>

            <br><br>

            <div class="row">
                <div class="col">
                    <label for="formulaBase" class="form-label">Formula Base</label>
                </div>
                <div class="col">
                    <label for="formulaRecalculada" class="form-label">Formula Recalculada</label>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="porcentaje" class="form-label">Porcentaje</label>
                    <input type="number" class="form-control" name="porcentaje">
                </div>
                <div class="col">
                    <label for="idFamilia" class="form-label">Familia</label>
                    <select name="idFamilia" id="idFamilia" class="form-control" required>
                        @foreach($familias as $familia)
                            <option value="{{ $familia->idFamilia }}">{{ $familia->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label for="contenido" class="form-label">Contenido</label>
                    <input type="text" class="form-control" name="contenido">
                </div>
                <div class="col">
                    <label for="idInsumo" class="form-label">Insumo</label>
                    <select name="idInsumo" id="idInsumo" class="form-control" required>
                        <option value="">Seleccione una familia primero</option>
                    </select>
                </div>
            </div>
            
            <br><br>

        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
    <br>
    
    <a href="{{ url()->previous() }}" class="btn btn-danger">Volver atrás</a>
@endsection


<!-- Cada vez que selecciono una familia, se llama a este script para buscar los insumos vinculados a esa familia -->
@section('scripts')
    <script src="{{ asset('js/productos.js') }}"></script>
@endsection