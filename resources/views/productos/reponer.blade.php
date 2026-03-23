@extends('layouts.admin')
@section('page', 'Reponer Producto')
@section('title')
    {{ Breadcrumbs::render('reponerProducto', $producto) }}
@endsection

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
                            <input type="number" name="stockInicial" class="form-control stockInicial" required>
                            <span class="input-group-text w-25 d-flex justify-content-center">unidades</span>
                        </div>
                        <div class="mt-3">
                            <label for="contenidoPorUnidad">Contenido por Unidad:</label>
                            <div class="input-group">
                                <input type="number" name="contenidoPorUnidad" class="form-control contenidoPorUnidad"
                                value="{{ $producto->contenidoPorUnidad }}" readonly required> 
                                <span class="input-group-text w-25 d-flex justify-content-center">gramos</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="fechaElaboracion">Fecha de elaboración:</label>
                            <input type="date" name="fechaElaboracion" class="form-control @error('fechaElaboracion') is-invalid @enderror" required>
                        </div>
                    </div>
                </div><br><br>
                

                <div class="card border-dark shadow">
                    <div class="card-body">
                        <p>Última Elaboración</p>
                        @include('productos.partials.estrFormula')
                        <div class="row">

                            <div id="contenedor-formulas">
                                @foreach($historial->formulas as $fila)
                                    <div class="row formula-item mb-2 align-items-center">
                                        <!-- Porcentaje -->
                                        <div class="col">
                                            <div class="input-group">
                                                <input type="number" name="porcentaje[]" value="{{ $fila->porcentaje }}" class="form-control porcentaje" required>
                                                <span class="input-group-text w-25 d-flex justify-content-center">%</span>   
                                            </div>
                                        </div>
                                        <!-- Familia -->
                                        <div class="col">
                                            <select name="familia[]" class="form-control select-familia" required>
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
                                                <input type="number" name="contenido[]" value="{{ $fila->contenido }}" class="form-control contenido" required>
                                                <span class="input-group-text w-25 d-flex justify-content-center">gr</span>
                                            </div>
                                        </div>
                                        <!-- Insumo -->
                                        <div class="col">
                                            <select name="insumo[]" class="form-control select-insumo" required>
                                                <option value="{{ $fila->insumo->idInsumo }}">{{ $fila->insumo->nombre }}</option>
                                            </select>
                                        </div>
                                        <!-- Botón eliminar -->
                                        <div class="col-auto">
                                            <button type="button" class="btn btn-danger btn-eliminar">
                                                <i class="bi bi-trash3-fill d-flex align-items-center justify-content-center"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div><br>

                        <div class="row g-3"> 
                            <div class="col-md-12">
                                <button type="button" id="btn-agregar" class="btn btn-primary w-100">
                                    Agregar
                                </button>
                            </div>
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
