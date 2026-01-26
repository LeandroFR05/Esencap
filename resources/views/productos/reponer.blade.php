@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/Productos/estCreate.css') }}">
@endsection

@section('title', 'Editar producto')
@section('content')
    <form action="{{ route('productos.reponer.store', $producto->idProducto) }}" method="POST">
        @csrf
        <label for="stock">Stock:</label>
        <input type="number" name="stock" required>
        <br>
        <label for="fechaElaboracion">Fecha de elaboración:</label>
        <input type="date" name="fechaElaboracion" required>
        <br>

        <p>Última Elaboración</p>
        @include('productos.partials.estrFormula')


        <div id="contenedor-formulas">
            @foreach($historial->formulas as $fila)
                <div class="row formula-item">
                    <div class="col">
                        <input type="number" name="porcentaje[]" value="{{ $fila->porcentaje }}" class="form-control porcentaje" required>
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
                        <input type="number" name="contenido[]" value="{{ $fila->contenido }}" class="form-control" required>
                    </div>
                    <div class="col">
                        <input type="hidden" name="insumo[]" value="{{ $fila->insumo->idInsumo }}">
                        <input type="text" value="{{ $fila->insumo->nombre }}" class="form-control" required>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Buttons -->
        <div class="botones-formula">
            <button type="button" id="btn-agregar" class="btn btn-primary">Agregar</button>
            <button type="button" id="btn-borrar" class="btn btn-danger">Borrar</button>
        </div>

        <br>
        <!-- Envía el formulario -->
        <button type="submit" class="btn btn-success">Reponer</button>
    </form>

    <a href="{{ route('productos.estante') }}" class="btn btn-danger">Volver atrás</a>
@endsection


@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


@section('scripts')
    <!-- Script para clonar la fórmula -->
    <script src="{{ asset('js/productos/clonarFormula.js') }}"></script>

    <!-- Borrar clon -->
    <script src="{{ asset('js/productos/borrarFormula.js') }}"></script>

    <!-- Cada vez que selecciono una familia, se llama a este script para buscar los insumos vinculados a esa familia -->
    <script src="{{ asset('js/productos/busquedaInsumos.js') }}"></script>

    <!-- Para controlar que el porcentaje llegue siempre a 100% -->
    <!-- <script src="{{ asset('js/productos/controlarPorcentaje.js') }}"></script> -->

    <!-- Para calcular el contenido -->
    <script src="{{ asset('js/productos/calcularContenido.js') }}"></script>
@endsection