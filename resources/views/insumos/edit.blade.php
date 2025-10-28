@extends('layouts.app')

@section('title', 'Editar insumo')
@section('content')

    <h1>Editar Insumo</h1>

    <form action="{{ route('insumos.update', $insumo->idInsumo) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="{{ $insumo->nombre }}" required>
        <br>
        <label for="foto">Foto:</label>
        <img src="{{ asset('storage/' . $insumo->foto) }}" width="100" height="100">
        <br>
        <label for="fase">Fase:</label>
        <input type="text" name="fase" value="{{ $insumo->fase }}" required>
        <br>
        <label for="nombre">Familia:</label>
        <input type="text" name="nombre" value="{{ $familia->nombre }}" required>
        <br>
        <label for="contenidoPorUnidad">Contenido por Unidad:</label>
        <input type="number" name="contenidoPorUnidad" value="{{ $insumo->contenidoPorUnidad }}" required>
        <br>
        
        <button type="submit">Editar</button>
    </form>

    <a href="{{ route('lotes.show', $insumo->idInsumo) }}">Ver Lotes</a>
    <br>
    <a href="{{ route('insumos.estante') }}">Volver atrás</a>

@endsection