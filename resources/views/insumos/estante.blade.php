@extends('layouts.app')

@section('title', 'Insumos')
@section('content')
    <h1>Estante de Insumos</h1>

    <ul>
        @if($insumos->isEmpty())
            <li>No hay insumos disponibles.</li>
        @else
            @foreach($insumos as $insumo)
                <li>{{ $insumo->nombre }}</li> -
                <a href="{{ route('insumos.edit', $insumo->idInsumo) }}">Editar</a> - 
                <a href="{{ route('insumos.reponer', $insumo->idInsumo) }}">Reponer</a>
            @endforeach
        @endif
    </ul>

    <a href="{{ route('insumos.create') }}">Nuevo Insumo</a>
@endsection