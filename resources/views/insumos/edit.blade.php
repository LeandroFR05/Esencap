<!-- PLANTILLA -->
@extends('layouts.admin')

@section('page', 'Editar Insumo')

@section('styles')
    @vite('resources/css/Productos/estCreate.css')
    <style>
        #dropzone-label {
            height: 20.5rem;
        }
    </style>
@endsection

@section('title')
    {{ Breadcrumbs::render('editarInsumo', $insumo) }}
@endsection

<!-- CONTENIDO -->
@section('content')
    <form action="{{ route('insumos.update', $insumo->idInsumo) }}" method="POST" enctype="multipart/form-data" id="updateForm">
        @csrf
        @method('PUT')

        <div class="row g-3 justify-content-center">
            @component('components.cards-formCreate')
                @slot('titulo')
                    <i class="bi bi-pencil-square me-2"></i>Editar {{ $insumo->nombre }}
                @endslot

                @slot('contenido')
                    <div class="row g-3">
                        <div class="col-md-12">
                            <!-- Nombre -->
                            <x-input-group 
                                name="nombre"
                                label="Nombre"
                                type="text"
                                icon="bi-tag"
                                value="{{ old('nombre', $insumo->nombre) }}"
                                required
                            />

                            <!-- Stock Total -->
                            <div class="mb-3 mt-3">
                                <label for="stockTotal" class="form-label fw-semibold">
                                    Stock Total
                                </label>

                                <div class="d-flex align-items-center">
                                    <div class="input-group" style="flex: 1;">
                                        <span class="input-group-text">
                                            <i class="bi bi-box-seam"></i>
                                        </span>

                                        <input
                                            type="number"
                                            id="stockTotal"
                                            name="stockTotal"
                                            value="{{ $stockActual }}"
                                            class="form-control"
                                            readonly
                                        >
                                        <span class="input-group-text">
                                            {{ $insumo->unidadDeMedida }}
                                        </span>
                                    </div>

                                    <a href="{{ route('insumos.lotes', $insumo->idInsumo) }}" class="btn btn-outline-info ms-2">
                                        <i class="bi bi-box-seam me-1"></i> Ver Lotes
                                    </a>
                                </div>
                            </div>

                            <!-- Fase -->
                            <div class="mb-3">
                                <label for="fase" class="form-label fw-semibold">
                                    Fase
                                </label>
                                <select name="fase" id="fase" class="form-control" required>
                                    <option value="Acuosa" {{ $insumo->fase == 'Acuosa' ? 'selected' : '' }}>
                                        Acuosa
                                    </option>
                                    <option value="Oleosa" {{ $insumo->fase == 'Oleosa' ? 'selected' : '' }}>
                                        Oleosa
                                    </option>
                                    <option value="Activos" {{ $insumo->fase == 'Activos' ? 'selected' : '' }}>
                                        Activos
                                    </option>
                                </select>
                            </div>

                            <!-- Familia -->
                            <div class="mb-3">
                                <label for="idFamilia" class="form-label fw-semibold">
                                    Familia
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-collection"></i>
                                    </span>

                                    @if($formula)
                                        <select name="idFamilia" id="idFamilia" class="form-control" required>
                                            <option value="{{ $insumo->idFamilia }}">
                                                {{ $insumo->familia->nombre }}
                                            </option>
                                        </select>
                                    @else
                                        <select name="idFamilia" id="idFamilia"
                                            class="form-control @error('idFamilia') is-invalid @enderror"
                                            required>
                                            @foreach($familias as $familia)
                                                <option
                                                    value="{{ $familia->idFamilia }}"
                                                    {{ $familia->idFamilia == $insumo->idFamilia ? 'selected' : '' }}>
                                                    {{ $familia->nombre }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFamilia">
                                            <i class="bi bi-plus-lg"></i>
                                        </button>
                                    @endif

                                    @error('idFamilia')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endslot
            @endcomponent

            <!-- Foto -->
            @component('components.cards-foto')
                @slot('titulo')
                    <i class="bi bi-image me-2"></i>Foto
                @endslot
                @slot('contenido')
                    <input type="hidden" name="remove_foto" id="remove-foto" value="0">
                    @include('_partials.dropzone', ['foto' => $insumo->foto])
                @endslot
            @endcomponent
        </div>
    </form><br>

    @component('components.cards')
        @slot('contenido')
            <div class="row g-3">
                <div class="col-md-8">
                    <button type="submit" class="btn btn-success w-100" form="updateForm">
                    <i class="bi bi-check-circle"></i> Guardar</button>
                </div>

                <div class="col-md-4">
                    <form action="{{ route('insumos.destroy', $insumo->idInsumo) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 delete-btn">
                            <i class="bi bi-trash3-fill"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @endslot
    @endcomponent

    <!--Llamamos a las ventanas modales-->
    @include('_modals.insumos.modalFamilia')
@endsection


@section('scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>
    <script src="{{ asset('js/removerImagenDropzone.js') }}"></script>
    <script src="{{ asset('js/confirmarEliminacion.js') }}"></script>
@endsection