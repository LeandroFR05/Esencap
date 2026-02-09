@extends('layouts.admin')
@section('page', 'Editar Producto')

@section('content')
    @component('_components.cards')
        @slot('titulo', 'Editar Producto')
        @slot('contenido')
            <!-- FORMULARIO -->
            <form action="{{ route('productos.update', $producto->idProducto) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Datos iniciales -->
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="{{ $producto->nombre }}" class="form-control" required>
                <br>
                <label for="foto">Foto:</label>
                <img src="{{ asset('storage/' . $producto->foto) }}" width="100" height="100">
                <input type="file" name="foto" class="form-control" accept="image/*">
                <br>
                <label for="stock">Stock total:</label>
                <input type="number" name="stock" value="{{ $stockTotal }}" class="form-control" style="background-color: #f3f3f3ff;" readonly>
                <br>
                <label for="contenidoPorUnidad">Contenido por Unidad:</label>
                <input type="number" name="contenidoPorUnidad" value="{{ $producto->contenidoPorUnidad }}" class="form-control" style="background-color: #f3f3f3ff;" readonly>
                <br>

                <!-- Enviar formulario -->
                <button type="submit" class="btn btn-success">Editar</button>
            </form>
        @endslot

        @slot('footer')
            <a href="{{ route('productos.reponer', $producto->idProducto) }}" class="btn btn-primary">Elaborar</a>
            <a href="{{ route('productos.estante') }}" class="btn btn-danger">Volver atrás</a>
            <!-- HISTORIAL DE ELABORACIONES -->
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" 
            aria-controls="offcanvasExample">
                Historial
            </button>
        @endslot
    @endcomponent

    @include('productos.partials.historial-offcanvas', ['producto' => $producto])

@endsection