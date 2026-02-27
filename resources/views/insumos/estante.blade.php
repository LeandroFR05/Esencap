@extends('layouts.admin')
@section('page', 'Insumos')
@section('title')
    <div class="d-flex justify-content-between align-items-center">
        {{ Breadcrumbs::render('insumos') }}
        <a href="{{ route('insumos.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Nuevo Insumo
        </a>
    </div>
@endsection

@section('content')
    <div class="container px-4 px-lg-2 mt-2">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4">
            @forelse($insumos as $insumo)
                @if($insumo->disponible == true)
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image-->
                            <x-foto :foto="$insumo->foto" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $insumo->nombre }}</h5>
                                    <!-- Product price-->
                                    Stock: {{ $insumo->lotes->sum('stockActual') }}gr
                                </div>
                            </div>

                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('insumos.reponer', $insumo->idInsumo) }}" 
                                    class="btn btn-outline-success">
                                        <i class="bi bi-plus-lg d-flex align-items-center justify-content-center"></i>
                                    </a>

                                    <a href="{{ route('insumos.edit', $insumo->idInsumo) }}" 
                                    class="btn btn-outline-warning">
                                        <i class="bi bi-pencil d-flex align-items-center justify-content-center"></i>
                                    </a>

                                    <a href="{{ route('lotes.show', $insumo->idInsumo) }}" 
                                    class="btn btn-outline-info">
                                        <i class="bi bi-box-seam d-flex align-items-center justify-content-center"></i>
                                    </a>
                                </div>    
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        No hay insumos disponibles en este momento.
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

