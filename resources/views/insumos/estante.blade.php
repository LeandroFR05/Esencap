@extends('layouts.app')

@section('title', 'Insumos')
@section('content')
    <h1>Estante de Insumos</h1>

    <ul>
        @if($insumos->isEmpty())
            <li>No hay insumos disponibles.</li>
        @else
            @foreach($insumos as $insumo)
                <li>{{ $insumo->nombre }}</li>
                <br>
                <img src="{{ asset('storage/' . $insumo->foto) }}" class="img-thumbnail" width="100" height="100">
                <br>
                <a href="{{ route('insumos.reponer', $insumo->idInsumo) }}"><i class="bi bi-plus-lg"></i></a> -
                <a href="{{ route('insumos.edit', $insumo->idInsumo) }}"><i class="bi bi-pencil"></i></a> 
            @endforeach
        @endif
    </ul>

    <a href="{{ route('insumos.create') }}">Nuevo Insumo</a>
@endsection