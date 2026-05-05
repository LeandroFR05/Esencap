@extends('layouts.admin')
@section('page', 'Insumos')
@section('title')
    <div class="d-flex justify-content-between align-items-center">
        {{ Breadcrumbs::render('insumos.eliminados') }}
    </div>
@endsection

@section('content')
    <div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-4">
        @forelse($insumosEliminados as $insumo)
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
                            
                            <a href="{{ route('insumos.restore', $insumo->idInsumo) }}" 
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
            </div>
            <div class="alert alert-info d-flex align-items-center justify-content-center mt-5" role="alert" style="min-height: 100px;">
                <div class="text-center">
                    <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                    <p class="mt-3 mb-0"><strong>No hay insumos eliminados en este momento.</strong></p>
                </div>
            </div>
            <div class="row row-cols-2 row-cols-md-3 row-cols-xl-5 g-4">
        @endforelse
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/tooltips/tooltips.js') }}"></script>
@endsection

