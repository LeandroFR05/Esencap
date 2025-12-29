@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/Productos/estCreate.css') }}">
@endsection

@section('title', 'Editar producto')
@section('content')
    <h1>Editar Producto</h1>

    <form action="{{ route('productos.update', $producto->idProducto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="{{ $producto->nombre }}" required>
        <br>
        <label for="foto">Foto:</label>
        <img src="{{ asset('storage/' . $producto->foto) }}" width="100" height="100">
        <input type="file" name="foto">
        <br>
        <label for="stock">Stock total:</label>
        <input type="number" name="stock" value="{{ $stockTotal }}" style="background-color: #f3f3f3ff;" readonly>
        <br>
        <label for="contenidoPorUnidad">Contenido por Unidad:</label>
        <input type="number" name="contenidoPorUnidad" value="{{ $producto->contenidoPorUnidad }}" style="background-color: #f3f3f3ff;" readonly>
        <br>
        
    
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
            </div>
            <div class="col">
                <label for="idFamilia" class="form-label">Familia</label>
            </div>
            <div class="col">
                <label for="contenido" class="form-label">Contenido</label>
            </div>
            <div class="col">
                <label for="idInsumo" class="form-label">Insumo</label>
            </div>
        </div>

        @foreach($formula as $fila)
            <div class="row formula-item">
                <div class="col">
                    <input type="number" name="porcentaje[]" value="{{ $fila['porcentaje'] }}" class="form-control porcentaje" required>
                </div>
                <div class="col">
                    <input type="text" name="familia[]" value="{{ $fila['familia'] }}" class="form-control" required>
                </div>
                <div class="col">
                    <input type="number" name="contenido[]" value="{{ $fila['contenido'] }}" class="form-control" required>
                </div>
                <div class="col">
                    <input type="text" name="insumo[]" value="{{ $fila['insumo'] }}" class="form-control" required>
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-success">Editar</button>
    </form>

    <!--Botón volver atrás-->
    <a href="{{ route('productos.estante') }}" class="btn btn-danger">Volver</a>
@endsection