@extends('layouts.admin')
@section('page', 'Reponer Producto')
@section('title')
    {{ Breadcrumbs::render('reponerProducto', $producto) }}
@endsection

<link rel="stylesheet" href="{{ asset('css/Productos/estCreate.css') }}">

@section('content')
    @component('components.cards')
        @slot('titulo')
            <i class="bi bi-plus-square me-2"></i>
            Reponer {{ $producto->nombre }}
        @endslot
        @slot('contenido')
            <form action="{{ route('productos.reponer.store', $producto->idProducto) }}" method="POST">
                @csrf
                <div class="row g-4">

                    <!-- Stock Inicial -->
                    <div class="col-12 col-md-4">
                        <div class="mb-3">
                            <label for="stockInicial" class="form-label fw-semibold">
                                Stock inicial
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-box"></i>
                                </span>

                                <input type="number"
                                    name="stockInicial"
                                    id="stockInicial"
                                    class="form-control stockInicial @error('stockInicial') is-invalid @enderror"
                                    required>

                                <span class="input-group-text">
                                    unidades
                                </span>

                                @error('stockInicial')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contenido por Unidad -->
                    <div class="col-12 col-md-4">
                        <div class="mb-3">
                            <label for="contenidoPorUnidad" class="form-label fw-semibold">
                                Contenido por Unidad
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-archive"></i>
                                </span>

                                <input type="number"
                                    name="contenidoPorUnidad"
                                    id="contenidoPorUnidad"
                                    value="{{ $producto->contenidoPorUnidad }}"
                                    class="form-control contenidoPorUnidad @error('contenidoPorUnidad') is-invalid @enderror"
                                    readonly
                                    required>

                                <span class="input-group-text">
                                    gramos
                                </span>

                                @error('contenidoPorUnidad')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Fecha de Elaboración -->
                    <div class="col-12 col-md-4">
                        <div class="mb-3">
                            <label for="fechaElaboracion" class="form-label fw-semibold">
                                Fecha de elaboración
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar-date"></i>
                                </span>

                                <input type="date"
                                    name="fechaElaboracion"
                                    id="fechaElaboracion"
                                    class="form-control @error('fechaElaboracion') is-invalid @enderror"
                                    required>

                                @error('fechaElaboracion')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="formula-card">
                    <div class="card-body p-4">
                        <p>Última Elaboración</p>
                        @include('productos.partials.estrFormula')
                        <div id="contenedor-formulas">
                            @foreach($historial->formulas as $fila)
                                <div class="row formula-item mb-2 align-items-center">
                                    <!-- Porcentaje -->
                                    <div class="col">
                                        <div class="input-group">
                                            <input type="number" name="porcentaje[]" value="{{ $fila->porcentaje }}" class="form-control form-control-sm porcentaje" required>
                                            <span class="input-group-text w-25 d-flex justify-content-center">%</span>   
                                        </div>
                                    </div>
                                    <!-- Familia -->
                                    <div class="col">
                                        <select name="familia[]" class="form-select form-select-sm select-familia" required>
                                            <option value="">Seleccione una familia</option>
                                            @foreach($familias as $familia)
                                                <option value="{{ $familia->idFamilia }}"
                                                    @selected($familia->idFamilia == $fila->familia->idFamilia)>
                                                    {{ $familia->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Contenido -->
                                    <div class="col">
                                        <div class="input-group">
                                            <input type="number" name="contenido[]" value="{{ $fila->contenido }}" class="form-control form-control-sm contenido" readonly>
                                            <span class="input-group-text w-25 d-flex justify-content-center">gr</span>
                                        </div>
                                    </div>
                                    <!-- Insumo -->
                                    <div class="col">
                                        <select name="insumo[]" class="form-select form-select-sm select-insumo" required>
                                            <option value="{{ $fila->insumo->idInsumo }}">{{ $fila->insumo->nombre }}</option>
                                        </select>
                                    </div>
                                    <!-- Botón eliminar -->
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
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
            <div class="row g-4">
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-success w-25">
                        <i class="bi bi-check-circle me-1"></i> Guardar</button>
                </div>
            </div>
        @endslot
            </form>

    @endcomponent

@endsection


@section('scripts')
    @include('productos.partials.scripts')
@endsection
