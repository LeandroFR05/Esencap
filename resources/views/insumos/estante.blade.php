@extends('layouts.admin')
@section('page', 'Insumos')
@section('title', 'Estante de Insumos')
@section('content')

    <ul>
        @if($insumos->isEmpty())
            <li>No hay insumos disponibles.</li>
        @else
            @foreach($insumos as $insumo)
                <div class="card" style="width: 13rem; display: inline-block; margin: 10px;">
                    <div class="card-header" style="text-align: center;">
                        <h5>{{ $insumo->nombre }}</h5>
                    </div>
                    <div class="card-body" style="text-align: center;">
                        <img src="{{ asset('storage/' . $insumo->foto) }}" class="img-thumbnail" width="100" height="100">
                    </div>
                    <div class="card-footer">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <a href="{{ route('insumos.reponer', $insumo->idInsumo) }}" class="btn btn-outline-success"><i class="bi bi-plus-lg"></i></a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('insumos.edit', $insumo->idInsumo) }}" class="btn btn-outline-warning"><i class="bi bi-pencil"></i></a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('lotes.show', $insumo->idInsumo) }}" class="btn btn-outline-info"><i class="bi bi-box-seam"></i></a>
                            </div>    
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </ul>

    <a href="{{ route('insumos.create') }}">Nuevo Insumo</a>
@endsection

@include('insumos.modals.modalCrearInsumo')

