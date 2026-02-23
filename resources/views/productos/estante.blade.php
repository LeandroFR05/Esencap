@extends('layouts.admin')
@section('page', 'Productos')
@section('title', 'Estante de Productos')
@section('content')

<div class="container px-4 px-lg-4 mt-2">
    <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">
        @forelse($productos as $producto)
            <div class="col mb-2">
                <div class="card h-100">
                    <!-- Product image-->
                    <x-foto :foto="$producto->foto" />
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">{{ $producto->nombre }}</h5>
                            <!-- Product price-->
                            Stock: {{ $producto->historiales->sum('stock') }}
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center"><a class="btn btn-outline-success mt-auto" 
                        href="{{ route('productos.edit', $producto->idProducto) }}">Editar</a></div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    No hay productos disponibles en este momento.
                </div>
            </div>
        @endforelse
    </div>
</div>

<a href="{{ route('productos.create') }}">Nuevo Producto</a>
@endsection
