@extends('layouts.admin')
@section('page', 'Editar Insumo')
@section('content')

    @component('_components.cards')
        @slot('titulo', 'Editar Insumo')

        @slot('contenido')
            <form action="{{ route('insumos.update', $insumo->idInsumo) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3" style="max-width: 600px; margin: auto;">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" value="{{ $insumo->nombre }}" class="form-control" required>
                    <br>
                    <label for="foto">Foto</label>
                    <img src="{{ asset('storage/' . $insumo->foto) }}" width="100" height="100">
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="stockTotal">Stock Total</label>
                        </div>
                        <div class="col-md-6">
                            <label for="cantEnvases">Cantidad de envases</label>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="input-group">
                            <input type="number" name="stockTotal" value="{{ $stockLotes }}" class="form-control" readonly>
                            <span class="input-group-text">gr</span>
                        </div>
                        <label>=</label>
                        <div class="input-group">
                            <input type="number" name="cantEnvases" 
                            value="{{ number_format($stockLotes / $insumo->contenidoPorUnidad, 2, '.', '') }}" class="form-control" readonly>
                            <span class="input-group-text">ud</span>
                        </div>
                    </div>
                    <br>
                    <label for="fase">Fase:</label>
                    <input type="text" name="fase" value="{{ $insumo->fase }}" class="form-control" required>
                    <br>
                    <label for="idFamilia">Familia</label>
                    <div class="d-flex align-items-center">
                        <select name="idFamilia" class="form-control" required>
                            @foreach($familias as $familia)
                                <!--Esta lógica selecciona la familia que actualmente esta utilizando el insumo-->
                                <option value="{{ $familia->idFamilia }}"
                                    {{ $familia->idFamilia == $insumo->idFamilia ? 'selected' : '' }}>
                                    {{ $familia->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <!--Usamos una botón que nos lleva a una ventana modal para poder crear familias-->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFamilia">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                    </div>
                    <br>
                    <label for="contenidoPorUnidad">Contenido por Unidad</label>
                    <input type="number" name="contenidoPorUnidad" value="{{ $insumo->contenidoPorUnidad }}" class="form-control" required>
                    <br>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">Editar</button>
                    </div>
                </div>
            </form>
        @endslot
        @slot('footer')
            <a href="{{ route('insumos.estante') }}" class="btn btn-danger">Volver atrás</a>
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalDeshabilitarInsumo">
                <i class="bi bi-slash-circle"></i> Deshabilitar
            </button>
        @endslot
    @endcomponent

    <!--Llamamos a las ventanas modales-->
    @include('_modals.modalFamilia')
    @include('_modals.modalDeshabilitarInsumo')
@endsection