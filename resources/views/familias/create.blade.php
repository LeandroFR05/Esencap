@extends('layouts.app')

@section('title', 'Nueva familia')
@section('content')
    <h1>Crear Nueva Familia</h1>

    <form method="POST" action="{{ route('familias.store') }}">
        @csrf
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
        </div>
        <div>
            <button type="submit">Agregar</button>
        </div>
    </form>
@endsection