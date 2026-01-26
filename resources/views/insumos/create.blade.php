@extends('layouts.app')

@section('title', 'Nuevo insumo')
@section('content')
    <h1>Crear Nuevo Insumo</h1>

    <form method="POST" action="{{ route('insumos.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" required>
            <br>
            <label for="foto">Foto:</label>
            <input type="file" name="foto">
            <br>
            <label for="stock">Cantidad de envases:</label>
            <input type="number" name="stock" required>
            <br>
            <label for="contenidoPorUnidad">Contenido por Unidad:</label>
            <input type="number" name="contenidoPorUnidad" required>
            <br>

            <label for="idFamilia">Familia:</label>
            <select name="idFamilia" required>
                @foreach($familias as $familia)
                    <option value="{{ $familia->idFamilia }}">{{ $familia->nombre }}</option>
                @endforeach
            </select>
            <!--Usamos una botón que nos lleva a una ventana modal para poder crear familias-->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFamilia">
                <i class="bi bi-plus-lg"></i>
            </button>

            <br>
            <label for="fase">Fase:</label>
            <input type="text" name="fase" required>
            <br>
            <label for="fechaVencimiento">Fecha de Vencimiento:</label>
            <input type="date" name="fechaVencimiento" required>
        </div>
        <div>
            <button type="submit" class="btn btn-success">Agregar</button>
        </div>
    </form>

    @include('_modals.modalFamilia')

    <a href="{{ url()->previous() }}" class="btn btn-danger">Volver atrás</a>

@endsection