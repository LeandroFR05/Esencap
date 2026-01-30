@extends('layouts.app')

@section('title', 'Editar insumo')
@section('content')

    <h1>Editar Insumo</h1>

    <form action="{{ route('insumos.update', $insumo->idInsumo) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="{{ $insumo->nombre }}" required>
        <br>
        <label for="foto">Foto:</label>
        <img src="{{ asset('storage/' . $insumo->foto) }}" width="100" height="100">
        <input type="file" name="foto">
        <br>
        <label for="stockTotal">Stock Total:</label>
        <input type="number" name="stockTotal" value="{{ $stockLotes }}" required>
        <label for="cantEnvases"> = Cantidad de envases:</label>
        <input type="number" name="cantEnvases" value="{{ number_format($stockLotes / $insumo->contenidoPorUnidad, 2, '.', '') }}" required>
        <br>
        <label for="fase">Fase:</label>
        <input type="text" name="fase" value="{{ $insumo->fase }}" required>
        <br>
        
        <label for="idFamilia">Familia:</label>
        <select name="idFamilia" required>
            @foreach($familias as $familia)
                <!--Esta lógica selecciona la familia que actualmente esta utilizando el insumo-->
                <option value="{{ $familia->idFamilia }}"
                    {{ $familia->idFamilia == $insumo->idFamilia ? 'selected' : '' }}>
                    {{ $familia->nombre }}
                </option>
            @endforeach
        </select>
        <!--Usamos una botón que nos lleva a una ventana modal para poder crear familias-->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFamilia">
            <i class="bi bi-plus-lg"></i>
        </button>

        <br>
        <label for="contenidoPorUnidad">Contenido por Unidad:</label>
        <input type="number" name="contenidoPorUnidad" value="{{ $insumo->contenidoPorUnidad }}" required>
        <br>
        
        <button type="submit" class="btn btn-success">Editar</button>
    </form>

    <!--Botones para deshabilitar y eliminar insumo-->
    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalDeshabilitarInsumo">
        <i class="bi bi-slash-circle"></i> Deshabilitar
    </button>

    <!--Botón volver atrás-->
    <a href="{{ route('insumos.estante') }}" class="btn btn-danger">Volver</a>

    <!--Llamamos a las ventanas modales-->
    @include('_modals.modalFamilia')
    @include('_modals.modalDeshabilitarInsumo')
@endsection