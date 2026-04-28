@extends('layouts.admin')
@section('page', 'Productos')
@section('title')
    <div class="d-flex justify-content-between align-items-center">
        {{ Breadcrumbs::render('productos.eliminados') }}
    </div>
@endsection

@section('content')
    <div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-4">
        @forelse($productosEliminados as $producto)
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
                            
                            <a href="{{ route('productos.restore', $producto->idProducto) }}" 
                                class="btn btn-outline-warning" 
                                data-bs-toggle="tooltip" 
                                title="Restaurar">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    No hay productos eliminados en este momento.
                </div>
            </div>
        @endforelse
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/tooltips/tooltips.js') }}"></script>
@endsection
