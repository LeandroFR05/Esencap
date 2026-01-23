@extends('layouts.app')

@section('title', 'Productos')
@section('content')
    <h1>Estante de Productos</h1>

    <ul>
        @if($productos->isEmpty())
            <li>No hay productos disponibles.</li>
        @else
        <!-- Si hay algún producto en la base de datos, lo muestro recorriendo cada uno -->
            @foreach($productos as $producto)
                <li>{{ $producto->nombre }}</li>
                <br>
                <img src="{{ asset('storage/' . $producto->foto) }}" class="img-thumbnail" width="100" height="100">
                <br>
                <a href="{{ route('productos.edit', $producto->idProducto) }}"><i class="bi bi-pencil"></i></a>
            @endforeach
        @endif
    </ul>

    <a href="{{ route('productos.create') }}">Nuevo Producto</a>
@endsection