@extends('layouts.admin')
@section('page', 'Editar Insumo')
@section('content')

    @component('components.cards')
        @slot('titulo', 'Editar Insumo')

        @slot('contenido')
            <form action="{{ route('insumos.update', $insumo->idInsumo) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" value="{{ $insumo->nombre }}" class="form-control" required>
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="stockTotal">Stock Total</label>
                                </div>
                                <div class="col-md-6">
                                    <label for="cantEnvases">Cantidad de envases</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
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
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="fase">Fase</label>
                                </div>
                                <div class="col-md-6">
                                    <label for="contPorUnidad">Contenido por Unidad</label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <input type="text" name="fase" value="{{ $insumo->fase }}" class="form-control" required>
                            <input type="number" name="contenidoPorUnidad" value="{{ $insumo->contenidoPorUnidad }}" 
                            class="form-control" required>
                        </div>
                        <div class="mt-3">
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
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="foto">Foto:</label>
                        <input type="hidden" name="remove_foto" id="remove-foto" value="0">
                        @include('_partials.dropzone', ['foto' => $insumo->foto])
                    </div>
                </div>
        @endslot

        @slot('footer')
            <div class="row g-3">
                <div class="col-md-8">
                    <button type="submit" class="btn btn-success w-100">Editar</button>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#modalDeshabilitarInsumo">
                        <i class="bi bi-slash-circle"></i> Deshabilitar
                    </button>
                </div>
            </div>
            </form>
        @endslot
    @endcomponent

    <!--Llamamos a las ventanas modales-->
    @include('_modals.modalFamilia')
    @include('_modals.modalDeshabilitarInsumo')
@endsection


@section('scripts')
    <script src="{{ asset('js/removerImagenDropzone.js') }}"></script>
@endsection