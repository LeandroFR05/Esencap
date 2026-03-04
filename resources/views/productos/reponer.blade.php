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
                        <label for="stock">Stock:</label>
                        <input type="number" name="stock" class="form-control stock" required>
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
                            <input type="date" name="fechaElaboracion" class="form-control" required>
                        </div>
                    </div>
                </div><br><br>

                <p>Última Elaboración</p>
                @include('productos.partials.estrFormula')


                <div id="contenedor-formulas">
                    @foreach($historial->formulas as $fila)
                        <div class="row formula-item mb-2">
                            <div class="col">
                                <div class="input-group">
                                    <input type="number" name="porcentaje[]" value="{{ $fila->porcentaje }}" class="form-control porcentaje" required>
                                    <span class="input-group-text w-25 d-flex justify-content-center">%</span>   
                                </div>
                            </div>
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
                            <div class="col">
                                <div class="input-group">
                                    <input type="number" name="contenido[]" value="{{ $fila->contenido }}" class="form-control contenido" required>
                                    <span class="input-group-text w-25 d-flex justify-content-center">gr</span>
                                </div>
                            </div>
                            <div class="col">
                                <!-- <input type="hidden" name="insumo[]" value="{{ $fila->insumo->idInsumo }}"> -->
                                <!-- <input type="text" value="{{ $fila->insumo->nombre }}" class="form-control" required> -->

                                <select name="insumo[]" class="form-control select-insumo" required>
                                    <option value="{{ $fila->insumo->idInsumo }}">{{ $fila->insumo->nombre }}</option>
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row g-3"> 
                    <div class="col-md-6">
                        <button type="button" id="btn-agregar" class="btn btn-primary w-100">
                            Agregar
                        </button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" id="btn-borrar" class="btn btn-danger w-100">
                            Borrar
                        </button>
                    </div>
                </div>
                <br>
        @endslot

        @slot('footer')
            <div class="row g-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success w-100">Reponer</button>
                </div>
            </div>
        @endslot
            </form>

    @endcomponent

@endsection


@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


@include('productos.partials.scripts')