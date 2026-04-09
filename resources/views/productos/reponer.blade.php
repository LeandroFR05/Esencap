@extends('layouts.admin')
@section('page', 'Reponer Producto')
@section('title')
    {{ Breadcrumbs::render('reponerProducto', $producto) }}
@endsection

<link rel="stylesheet" href="{{ asset('css/Productos/estCreate.css') }}">

@section('content')
    @component('components.cards')
        @slot('titulo', 'Reponer ' . $producto->nombre)
        @slot('contenido')
            <form action="{{ route('productos.reponer.store', $producto->idProducto) }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-md-12">
                        <label for="stockInicial">Stock inicial:</label>
                        <div class="input-group">
                            <input type="number" name="stockInicial" id="stockInicial" class="form-control stockInicial" required>
                            <span class="input-group-text w-25 d-flex justify-content-center">unidades</span>
                        </div>
                        <div class="mt-3">
                            <label for="contenidoPorUnidad">Contenido por Unidad:</label>
                            <div class="input-group">
                                <input type="number" name="contenidoPorUnidad" id="contenidoPorUnidad" class="form-control contenidoPorUnidad"
                                value="{{ $producto->contenidoPorUnidad }}" readonly required> 
                                <span class="input-group-text w-25 d-flex justify-content-center">gramos</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="fechaElaboracion">Fecha de elaboración:</label>
                            <input type="date" name="fechaElaboracion" id="fechaElaboracion" class="form-control @error('fechaElaboracion') is-invalid @enderror" required>
                        </div>
                    </div>
                </div><br><br>
                

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
            <div class="row g-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success w-100">Guardar</button>
                </div>
            </div>
        @endslot
            </form>

    @endcomponent

@endsection


@section('scripts')
    @include('productos.partials.scripts')
@endsection
