@extends('layouts.admin')
@section('page', 'Productos')
@section('title')
    <div class="d-flex justify-content-between align-items-center">
        {{ Breadcrumbs::render('productos') }}
        <a href="{{ route('productos.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Nuevo Producto
        </a>
    </div>
@endsection

@section('content')
    <div class="container px-4 px-lg-2 mt-2">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">
            @forelse($productos as $producto)
                <div class="col mb-5">
                    <div class="card h-100">
                        <!-- Product image-->
                        <x-foto :foto="$producto->foto" />
                        <!-- Product details-->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <!-- Product name-->
                                <h5 class="fw-bolder">{{ $producto->nombre }}</h5>
                                <!-- Product price-->
                                Stock: {{ $producto->historiales->sum('stockActual') }}u.
                            </div>
                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="d-flex justify-content-center gap-2">
                                
                                <a href="{{ route('productos.reponer', $producto->idProducto) }}" 
                                    class="btn btn-outline-success" 
                                    data-bs-toggle="tooltip" 
                                    title="Reponer Stock">
                                    <i class="bi bi-plus-lg"></i>
                                </a>
                                <a href="{{ route('productos.edit', $producto->idProducto) }}" 
                                    class="btn btn-outline-warning" 
                                    data-bs-toggle="tooltip" 
                                    title="Editar Producto">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="{{ route('productos.historial', $producto->idProducto) }}" 
                                    class="btn btn-outline-info" 
                                    data-bs-toggle="tooltip" 
                                    title="Ver Historial">
                                    <i class="bi bi-clock-history"></i>
                                </a>
                                
                            </div>
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
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection
