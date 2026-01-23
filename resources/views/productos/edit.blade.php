@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/Productos/estCreate.css') }}">
@endsection

@section('title', 'Editar producto')
@section('content')
    <h1>Editar Producto</h1>

    <!-- FORMULARIO -->
    <form action="{{ route('productos.update', $producto->idProducto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Datos iniciales -->
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

        <!-- Enviar formulario -->
        <button type="submit" class="btn btn-success">Editar</button>
    </form>

    <button class="btn btn-primary">Elaborar</button>

    <br>


    <!-- HISTORIAL DE ELABORACIONES -->
    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" 
    aria-controls="offcanvasExample">
        Historial
    </button>

    @include('productos.partials.historial-offcanvas', ['producto' => $producto])

    
    <!--VOLVER ATRÁS-->
    <a href="{{ route('productos.estante') }}" class="btn btn-danger">Volver</a>

@endsection