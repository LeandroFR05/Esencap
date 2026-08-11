@extends('layouts.admin')
@section('page', 'Insumos')
@section('title')
    <div class="d-flex justify-content-between align-items-center">
        {{ Breadcrumbs::render('insumos') }}
        <div class="d-flex gap-2">
            <a href="{{ route('insumos.eliminados') }}" class="btn btn-danger">
                <i class="bi bi-trash"></i> Ver insumos eliminados
            </a>
            <a href="{{ route('insumos.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> Nuevo Insumo
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="card shadow-sm mb-3">
        <div class="card-body p-3">
            
            <form method="GET" action="{{ route('insumos.estante') }}" id="formFiltros">
                <div class="row g-3">
                    <!-- Búsqueda de insumos -->
                    <div class="col-md-4">
                        <label for="nombre" class="form-label fw-semibold small">Buscar por nombre</label>
                        <input type="text" id="nombre" name="nombre" placeholder="Buscar insumo..." 
                        value="{{ request('nombre', '') }}" class="form-control form-control-sm">
                    </div>

                    <!-- Filtro por familia -->
                    <div class="col-md-4">
                        <label for="familia" class="form-label fw-semibold small">Familia</label>
                        <select id="familia" name="familia" class="form-select form-select-sm">
                            <option value="">Todas</option>
                            @foreach($familias as $familia)
                                <option value="{{ $familia->idFamilia }}" {{ request('familia') == $familia->idFamilia ? 'selected' : '' }}>{{ $familia->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Ordenar por fecha -->
                    <div class="col-md-4">
                        <label for="fecha" class="form-label fw-semibold small">Ordenar por fecha de elaboración</label>
                        <select id="fecha" name="fecha" class="form-select form-select-sm">
                            <option value="">Sin orden</option>
                            <option value="reciente" {{ request('fecha') === 'reciente' ? 'selected' : '' }}>Más reciente</option>
                            <option value="antigua" {{ request('fecha') === 'antigua' ? 'selected' : '' }}>Más antigua</option>
                        </select>
                    </div>
                    
                    <!-- Botones -->
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-sm btn-primary w-100">
                            <i class="bi bi-search"></i> Buscar
                        </button>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" onclick="limpiarFiltrosInsumos()" class="btn btn-sm btn-secondary w-100">
                            <i class="bi bi-x-circle"></i> Limpiar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-4">
        @forelse($insumos as $insumo)
            <div class="col mb-1">
                <div class="card h-100">
                    <!-- Product image-->
                    <x-foto :foto="$insumo->foto" />
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder">{{ $insumo->nombre }}</h5>
                            <!-- Product price-->
                            Stock: {{ $insumo->lotes->sum('stockActual') }} {{ $insumo->unidadDeMedida }}
                        </div>
                    </div>

                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="d-flex justify-content-center gap-2">
                            
                            <a href="{{ route('insumos.reponer', $insumo->idInsumo) }}" 
                                class="btn btn-outline-success" 
                                data-bs-toggle="tooltip" 
                                title="Reponer Stock">
                                <i class="bi bi-plus-lg"></i>
                            </a>

                            <a href="{{ route('insumos.edit', $insumo->idInsumo) }}" 
                                class="btn btn-outline-warning" 
                                data-bs-toggle="tooltip" 
                                title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <a href="{{ route('insumos.lotes', $insumo->idInsumo) }}" 
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
                    <i class="bi bi-box" style="font-size: 3rem;"></i>
                    <p class="mt-3 mb-0"><strong>No hay insumos disponibles en este momento.</strong></p>
                </div>
            </div>
            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-4">
        @endforelse
    </div>
    <br>
    <div class="d-flex justify-content-center">
        {{ $insumos->links() }}
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/tooltips/tooltips.js') }}"></script>
    <script src="{{ asset('js/insumos/filtrosEstante.js') }}"></script>
    <script src="{{ asset('js/busquedaGeneral.js') }}"></script>
@endsection

