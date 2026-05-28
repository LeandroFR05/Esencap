@extends('layouts.admin')
@section('page', 'Productos')
@section('title')
    <div class="d-flex justify-content-between align-items-center">
        {{ Breadcrumbs::render('productos') }}
        <div class="d-flex gap-2">
            <a href="{{ route('productos.eliminados') }}" class="btn btn-danger">
                <i class="bi bi-trash"></i> Ver productos eliminados
            </a>
            <a href="{{ route('productos.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> Nuevo Producto
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="d-flex align-items-start gap-3 mb-3">
        <div class="card shadow-sm" style="width: 280px;">
            <div class="card-body p-2">
                <form method="GET" action="{{ route('productos.estante') }}" id="formFiltros">
                    <label for="ordenarFecha" class="form-label fw-semibold small mb-1">Ordenar por fecha de elaboración</label>
                    <select id="ordenarFecha" name="ordenarFecha" class="form-select form-select-sm">
                        <option value="">Sin orden</option>
                        <option value="reciente" {{ request('ordenarFecha') === 'reciente' ? 'selected' : '' }}>Más reciente</option>
                        <option value="antigua" {{ request('ordenarFecha') === 'antigua' ? 'selected' : '' }}>Más antigua</option>
                    </select>
                </form>
            </div>
        </div>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-4">
        @forelse($productos as $producto)
            <div class="col mb-1">
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
                            <a href="{{ route('productos.lotes', $producto->idProducto) }}" 
                                class="btn btn-outline-info" 
                                data-bs-toggle="tooltip" 
                                title="Ver Lotes">
                                <i class="bi bi-box-seam"></i>
                            </a>
                            
                        </div>
                    </div>
                </div>
            </div>
        @empty
            </div>
            <div class="alert alert-info d-flex align-items-center justify-content-center mt-5" role="alert" style="min-height: 100px;">
                <div class="text-center">
                    <i class="bi bi-box2" style="font-size: 3rem;"></i>
                    <p class="mt-3 mb-0"><strong>No hay productos disponibles en este momento.</strong></p>
                </div>
            </div>
            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-4">
        @endforelse
    </div>
    <br>
    <div class="d-flex justify-content-center">
        {{ $productos->links() }}
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/tooltips/tooltips.js') }}"></script>
    <script src="{{ asset('js/productos/filtrosEstante.js') }}"></script>
@endsection
