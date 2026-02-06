@extends('layouts.admin')
@section('page', 'Productos')
@section('title', 'Estante de Productos')
@section('content')

    <ul>
        @if($productos->isEmpty())
            <li>No hay productos disponibles.</li>
        @else
        <!-- Si hay algún producto en la base de datos, lo muestro recorriendo cada uno -->
            @foreach($productos as $producto)
                <div class="card" style="width: 13rem; display: inline-block; margin: 10px;">
                    <div class="card-header" style="text-align: center;">
                        <h5>{{ $producto->nombre }}</h5>
                    </div>
                    <div class="card-body" style="text-align: center;">
                        <img src="{{ asset('storage/' . $producto->foto) }}" class="img-thumbnail" width="100" height="100">
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('productos.edit', $producto->idProducto) }}"><i class="bi bi-pencil"></i> Editar</a>
                    </div>
                </div>
            @endforeach
        @endif
    </ul>

    <a href="{{ route('productos.create') }}">Nuevo Producto</a>
@endsection