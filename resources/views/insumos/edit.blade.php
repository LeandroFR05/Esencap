@extends('layouts.admin')
@section('page', 'Editar Insumo')
@section('title')
    {{ Breadcrumbs::render('editarInsumo', $insumo) }}
@endsection

@section('content')

    @component('components.cards')
        @slot('titulo', 'Editar ' . $insumo->nombre)

        @slot('contenido')
            <form action="{{ route('insumos.update', $insumo->idInsumo) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" value="{{ $insumo->nombre }}" class="form-control @error('nombre') is-invalid @enderror" required>
                        <div class="mt-3">
                            <label for="stockTotal">Stock Actual</label>
                            <div class="input-group">
                                <input type="number" id="stockTotal" name="stockTotal" value="{{ $stockActual }}" class="form-control" readonly>
                                <span class="input-group-text w-25 d-flex justify-content-center">{{ $insumo->unidadDeMedida }}</span>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="fase">Fase</label>
                            <input type="text" name="fase" value="{{ $insumo->fase }}" class="form-control @error('fase') is-invalid @enderror" required>
                        </div>
                        <div class="mt-3">
                            <label for="idFamilia">Familia</label>
                            <div class="d-flex align-items-center">
                                @if($formula)
                                    <select name="idFamilia" class="form-control" required>
                                        <option value="{{ $insumo->idFamilia }}">{{ $insumo->familia->nombre }}</option>
                                    </select>
                                @else
                                    <select name="idFamilia" class="form-control" required>
                                        @foreach($familias as $familia)
                                            <!--Esta lógica selecciona la familia que actualmente esta utilizando el insumo-->
                                            <option value="{{ $familia->idFamilia }}"
                                                {{ $familia->idFamilia == $insumo->idFamilia ? 'selected' : '' }}>
                                                {{ $familia->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFamilia">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                @endif
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
                <div class="col-md-2">
                    <a href="{{ route('lotes.show', $insumo->idInsumo) }}" 
                    class="btn btn-outline-info w-100">
                        <i class="bi bi-box-seam"></i> Ver Lotes
                    </a>
                </div>
                <div class="col-md-6">
                    <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-check-circle"></i> Guardar</button>
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#modalDeshabilitarInsumo">
                        <i class="bi bi-trash3-fill"></i> Eliminar
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