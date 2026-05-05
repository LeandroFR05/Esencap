@extends('layouts.admin')
@section('page', 'Nuevo Producto')
@section('title')
    {{ Breadcrumbs::render('nuevo') }}
@endsection

<link rel="stylesheet" href="{{ asset('css/Productos/estCreate.css') }}">

@section('content')
    @component('components.cards')
        @slot('titulo', 'Crear Nuevo Producto')
        @slot('contenido')
            <form id="formProductos" method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">

                        <!-- Nombre -->
                        <x-input-group 
                            name="nombre"
                            label="Nombre"
                            type="text"
                            icon="bi-tag"
                            value="{{ old('nombre') }}"
                            required
                        />

                        <!-- Stock inicial -->
                        <div class="mb-3">
                            <label for="stockInicial" class="form-label fw-semibold">
                                Stock inicial
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-box"></i>
                                </span>

                                <input type="number" name="stockInicial" id="stockInicial" value="{{ old('stockInicial') }}"
                                    class="form-control stockInicial @error('stockInicial') is-invalid @enderror" required>
                                <span class="input-group-text w-25">
                                    unidades
                                </span>

                                @error('stockInicial')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Contenido por Unidad -->
                        <div class="mb-3">
                            <label for="contenidoPorUnidad" class="form-label fw-semibold">
                                Contenido por Unidad
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-archive"></i>
                                </span>

                                <input type="number" name="contenidoPorUnidad" id="contenidoPorUnidad" value="{{ old('contenidoPorUnidad') }}"
                                    class="form-control contenidoPorUnidad @error('contenidoPorUnidad') is-invalid @enderror" required>
                                <span class="input-group-text w-25">
                                    gramos
                                </span>

                                @error('contenidoPorUnidad')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Fecha de Elaboración -->
                        <x-input-group
                            name="fechaElaboracion"
                            label="Fecha de Elaboración"
                            type="date"
                            icon="bi-calendar-date"
                            value="{{ old('fechaElaboracion') }}"
                            required
                        />
                    </div>

                    <div class="col-md-6">
                        <div class="card border">
                            <div class="card-header bg-body-secondary">
                                <i class="bi bi-image me-2"></i>
                                Foto
                            </div>

                            <div class="card-body">
                                @include('_partials.dropzone')
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <!-- FÓRMULA -->
                <div class="formula-card">
                    <div class="card-body p-4">
                        @include('productos.partials.estrFormula')
                        <div id="contenedor-formulas">
                            <div class="row formula-item mb-2 align-items-center">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="number" name="porcentaje[]" class="form-control form-control-sm porcentaje" placeholder="0.00" required>
                                        <span class="input-group-text input-group-text-sm">%</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <select name="familia[]" class="form-select form-select-sm select-familia" required>
                                        <option value="">Seleccione una familia</option>
                                        @foreach($familias as $familia)
                                            <option value="{{ $familia->idFamilia }}">{{ $familia->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <div class="input-group">
                                        <input type="number" name="contenido[]" class="form-control form-control-sm contenido" readonly>
                                        <span class="input-group-text input-group-text-sm">gr</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <select name="insumo[]" class="form-select form-select-sm select-insumo" required>
                                        <option value="">Insumo</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="button" id="btn-agregar" class="btn btn-outline-primary w-100">
                                <i class="bi bi-plus-circle me-2"></i>Agregar fórmula
                            </button>
                        </div>
                    </div>
                </div>
        @endslot

        @slot('footer')
            <!-- Enviar formulario -->
            <div class="row g-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle me-1"></i> Guardar
                    </button>
                </div>
            </div>
            </form>
        @endslot
    @endcomponent
    
@endsection

@section('scripts')
    @include('productos.partials.scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>
@endsection







