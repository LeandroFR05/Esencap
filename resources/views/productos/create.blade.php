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
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" class="form-control" required>
                        <div class="mt-3"> <!-- mt= margin-top -->
                            <label for="stockInicial">Stock inicial</label>
                            <div class="input-group">
                                <input type="number" name="stockInicial" value="{{ old('stockInicial') }}" class="form-control stockInicial" required>
                                <span class="input-group-text w-25 d-flex justify-content-center">unidades</span>
                            </div>
                        </div>
                        <div class="mt-3"> 
                            <label for="contenidoPorUnidad">Contenido por Unidad</label>
                            <div class="input-group">
                                <input type="number" name="contenidoPorUnidad" value="{{ old('contenidoPorUnidad') }}" 
                                class="form-control contenidoPorUnidad" required>
                                <span class="input-group-text w-25 d-flex justify-content-center">gramos</span>
                            </div>    
                        </div>
                        <div class="mt-3">
                            <label for="fechaElaboracion">Fecha de Elaboración</label>
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
                                <div class="row formula-item mb-2 align-items-center">
                                    <!-- Porcentaje -->
                                    <div class="col">
                                        <div class="input-group">
                                            <input type="number" step="0.01" name="porcentaje[]" 
                                            class="form-control porcentaje" required>
                                            <span class="input-group-text w-25 d-flex justify-content-center">%</span>
                                        </div>
                                    </div>
                                    <!-- Familia -->
                                    <div class="col">
                                        <select name="familia[]" class="form-control select-familia" required>
                                            <option value="">Seleccione una familia</option>
                                            @foreach($familias as $familia)
                                                <option value="{{ $familia->idFamilia }}">{{ $familia->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Contenido -->
                                    <div class="col">
                                        <div class="input-group">
                                            <input type="number" name="contenido[]" class="form-control contenido" readonly>
                                            <span class="input-group-text w-25 d-flex justify-content-center">gr</span>
                                        </div>
                                    </div>
                                    <!-- Insumo -->
                                    <div class="col">
                                        <select name="insumo[]" class="form-control select-insumo" required>
                                            <option value=""></option>
                                        </select>
                                    </div>
                                    <!-- Botón eliminar -->
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-danger btn-eliminar">
                                            <i class="bi bi-trash3-fill d-flex align-items-center justify-content-center"></i>
                                        </button>
                                    </div>
                                </div>
                            </div><br>
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

@section('scripts')
    @include('productos.partials.scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>
    
@endsection







