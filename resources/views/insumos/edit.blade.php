@extends('layouts.admin')
@section('page', 'Editar Insumo')
@section('title')
    {{ Breadcrumbs::render('editarInsumo', $insumo) }}
@endsection

@section('content')

    @component('components.cards')
        @slot('titulo', 'Editar ' . $insumo->nombre)

        @slot('contenido')
            <form action="{{ route('insumos.update', $insumo->idInsumo) }}" method="POST" enctype="multipart/form-data" id="updateForm">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    <div class="col-md-6">

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
                        <div class="mb-3">
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
                                        style="background-color: #f3f3f3ff;"
                                        readonly
                                    >
                                    <span class="input-group-text">
                                        {{ $insumo->unidadDeMedida }}
                                    </span>
                                </div>

                                <a href="{{ route('lotes.show', $insumo->idInsumo) }}" class="btn btn-outline-info ms-2">
                                    <i class="bi bi-box-seam me-1"></i> Ver Lotes
                                </a>
                            </div>
                        </div>

                        <!-- Fase -->
                        <x-input-group 
                            name="fase"
                            label="Fase"
                            type="text"
                            icon="bi-diagram-3"
                            value="{{ old('fase', $insumo->fase) }}"
                            required
                        />
                        
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
                                    <select name="idFamilia" id="idFamilia" class="form-control"
                                        style="background-color: #f3f3f3ff;" required
                                    >
                                        <option value="{{ $insumo->idFamilia }}">
                                            {{ $insumo->familia->nombre }}
                                        </option>
                                    </select>
                                @else
                                    <select name="idFamilia" id="idFamilia"
                                        class="form-control @error('idFamilia') is-invalid @enderror"
                                        required
                                    >
                                        @foreach($familias as $familia)
                                            <option
                                                value="{{ $familia->idFamilia }}"
                                                {{ $familia->idFamilia == $insumo->idFamilia ? 'selected' : '' }}
                                            >
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

                    <div class="col-12 col-md-6">
                        <div class="card border">
                            <div class="card-header bg-body-secondary">
                                <i class="bi bi-image me-2"></i>
                                Foto
                            </div>

                            <div class="card-body">
                                <input type="hidden" name="remove_foto" id="remove-foto" value="0">
                                @include('_partials.dropzone', ['foto' => $insumo->foto])
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endslot

        @slot('footer')
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
    @include('_modals.modalFamilia')
@endsection


@section('scripts')
    <script src="{{ asset('js/removerImagenDropzone.js') }}"></script>
    <script src="{{ asset('js/confirmarEliminacion.js') }}"></script>
@endsection