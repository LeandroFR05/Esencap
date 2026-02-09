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
                    <div class="card-footer" style="display: flex; justify-content: center; gap: 30px;">
                        <a href="{{ route('insumos.reponer', $insumo->idInsumo) }}"><i class="bi bi-plus-lg"></i></a>
                        <a href="{{ route('insumos.edit', $insumo->idInsumo) }}"><i class="bi bi-pencil"></i></a>
                        <a href="{{ route('lotes.show', $insumo->idInsumo) }}"><i class="bi bi-box-seam"></i></a>
                    </div>
                </div>
            @endforeach
        @endif
    </ul>

    <button 
        class="btn btn-sm btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#modalCreateInsumo"
        onclick="cargarModalInsumo()">
        Nuevo Insumo
    </button>

    <a href="{{ route('insumos.create') }}">Nuevo Insumo</a>
@endsection

@include('insumos.modals.modalCrearInsumo')

<script>
    function cargarModalInsumo() {
        fetch("{{ route('insumos.create') }}")
            .then(res => res.text())
            .then(html => {
                document.getElementById('modal-body-insumo').innerHTML = html;
            });
    }
</script>