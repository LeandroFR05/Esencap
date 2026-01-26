@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/Productos/estCreate.css') }}">
@endsection

@section('title', 'Nuevo producto')
@section('content')
    <h1>Crear Nuevo Producto</h1>

    <form id="formProductos" method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <!-- INFORMACIÓN INICIAL -->
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="{{ old('nombre') }}" required>
            <br>
            <label for="foto">Foto:</label>
            <input type="file" name="foto">
            <br>
            <label for="stock">Stock:</label>
            <input type="number" name="stock" value="{{ old('stock') }}" required>
            <br>
            <label for="contenidoPorUnidad">Contenido por Unidad:</label>
            <input type="number" name="contenidoPorUnidad" class="contenidoPorUnidad" value="{{ old('contenidoPorUnidad') }}" required>
            <br>
            <label for="fechaElaboracion">Fecha de Elaboración:</label>
            <input type="date" name="fechaElaboracion" value="{{ old('fechaElaboracion') }}" required>

            <br><br>

            <!-- FÓRMULA -->
            @include('productos.partials.estrFormula')

            <!-- Inputs y Selects -->
            <div id="contenedor-formulas">
                <div class="row formula-item">
                    <div class="col">
                        <input type="number" name="porcentaje[]" class="form-control porcentaje" required>
                    </div>
                    <div class="col">
                        <select name="familia[]" class="form-control select-familia" required>
                            @foreach($familias as $familia)
                                <option value="{{ $familia->idFamilia }}">{{ $familia->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <input type="number" name="contenido[]" class="form-control contenido" readonly required>
                    </div>
                    <div class="col">
                        <select name="insumo[]" class="form-control select-insumo" required>
                            <option value="">Seleccione una familia primero</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="botones-formula">
                <button type="button" id="btn-agregar" class="btn btn-primary">Agregar</button>
                <button type="button" id="btn-borrar" class="btn btn-danger">Borrar</button>
            </div>
        </div>
        <br>

        <!-- Enviar formulario -->
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>

    <br>
    
    <a href="{{ url()->previous() }}" class="btn btn-danger">Volver atrás</a>
@endsection


<!-- Este error se muestra cuando no hay suficiente stock -->
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





