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

                            <a href="{{ route('lotes.show', $insumo->idInsumo) }}" 
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
@endsection

