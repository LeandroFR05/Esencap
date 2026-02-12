@extends('layouts.admin')
@section('page', 'Nuevo Insumo')
@section('content')

    @component('_components.cards')
        @slot('titulo', 'Crear Nuevo Insumo')
        @slot('contenido')
            <form method="POST" action="{{ route('insumos.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" required>
                        <div class="mt-3">
                            <label for="stock">Cantidad de envases:</label>
                            <input type="number" name="stock" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="contenidoPorUnidad">Contenido por Unidad:</label>
                            <input type="number" name="contenidoPorUnidad" class="form-control" required>
                        </div>
                        <div class="mt-3">
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
                        <div class="mt-3">
                            <label for="fase">Fase:</label>
                            <input type="text" name="fase" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="nombre">Foto:</label>
                        @include('_partials.dropzone')
                        <div class="mt-3">
                            <label for="fechaVencimiento">Fecha de Vencimiento:</label>
                            <input type="date" name="fechaVencimiento" class="form-control" required>
                        </div>
                    </div>
                </div>
                <br>
        @endslot

        @slot('footer')
            <div class="row g-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success w-100">Agregar</button>
                </div>
            </div>
        @endslot
            </form>

    @endcomponent

    @include('_modals.modalFamilia')

@endsection

@section('scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>
@endsection