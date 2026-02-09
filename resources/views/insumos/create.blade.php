@extends('layouts.admin')
@section('page', 'Nuevo Insumo')
@section('content')

    @component('_components.cards')
        @slot('titulo', 'Crear Nuevo Insumo')
        @slot('contenido')
            <form method="POST" action="{{ route('insumos.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col" style="max-width: 600px; margin: auto;">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" required>
                        <br>
                        <label for="foto">Foto:</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <br>
                        <label for="stock">Cantidad de envases:</label>
                        <input type="number" name="stock" class="form-control" required>
                        <br>
                        <label for="contenidoPorUnidad">Contenido por Unidad:</label>
                        <input type="number" name="contenidoPorUnidad" class="form-control" required>
                        <br>
                        <label for="idFamilia">Familia:</label>
                        <div class="d-flex align-items-center">
                            <select name="idFamilia" class="form-control" required>
                                @foreach($familias as $familia)
                                    <option value="{{ $familia->idFamilia }}">{{ $familia->nombre }}</option>
                                @endforeach
                            </select>
                            <!--Usamos una botón que nos lleva a una ventana modal para poder crear familias-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFamilia">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col" style="max-width: 600px; margin: auto;">
                        <br>
                        <label for="fase">Fase:</label>
                        <input type="text" name="fase" class="form-control" required>
                        <br>
                        <label for="fechaVencimiento">Fecha de Vencimiento:</label>
                        <input type="date" name="fechaVencimiento" class="form-control" required>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">Agregar</button>
                    </div>
                </div>
            </form>
        @endslot

        @slot('footer')
            <a href="{{ url()->previous() }}" class="btn btn-danger">Volver atrás</a>
        @endslot
    @endcomponent

    @include('_modals.modalFamilia')

@endsection