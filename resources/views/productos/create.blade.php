@extends('layouts.admin')
@section('page', 'Nuevo Producto')
@section('title')
    {{ Breadcrumbs::render('nuevo') }}
@endsection

@section('content')
    @component('components.cards')
        @slot('titulo', 'Crear Nuevo Producto')
        @slot('contenido')
            <form id="formProductos" method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <!-- INFORMACIÓN INICIAL -->
                        <label for="nombre">Nombre (*)</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
                        <div class="mt-3"> <!-- mt= margin-top -->
                            <label for="stock">Stock (*)</label>
                            <input type="number" name="stock" value="{{ old('stock') }}" class="form-control" required>
                        </div>
                        <div class="mt-3"> 
                            <label for="contenidoPorUnidad">Contenido por Unidad (*)</label>
                            <input type="number" name="contenidoPorUnidad" value="{{ old('contenidoPorUnidad') }}" class="form-control contenidoPorUnidad" required>
                        </div>
                        <div class="mt-3">
                            <label for="fechaElaboracion">Fecha de Elaboración (*)</label>
                            <input type="date" name="fechaElaboracion" value="{{ old('fechaElaboracion') }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="foto">Foto</label>
                        @include('_partials.dropzone')
                    </div>
                </div>
                <br><br>
                
                <!-- FÓRMULA -->
                <div class="card border-dark shadow">
                    <div class="card-body">
                        @include('productos.partials.estrFormula')
                        <div class="row">
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
                            </div><br>
                        </div><br>

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
                    </div>
                </div>
        @endslot

        @slot('footer')
            <!-- Enviar formulario -->
            <div class="row g-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success w-100">Guardar</button>
                </div>
            </div>
            </form>
        @endslot
    @endcomponent
    
@endsection


<!-- Este error se muestra cuando no hay suficiente stock -->
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


@section('scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>

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





