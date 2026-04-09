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
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <!-- INFORMACIÓN INICIAL -->
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="form-control" required>
                        <div class="mt-3"> <!-- mt= margin-top -->
                            <label for="stockInicial">Stock inicial</label>
                            <div class="input-group">
                                <input type="number" name="stockInicial" id="stockInicial" value="{{ old('stockInicial') }}" class="form-control stockInicial" required>
                                <span class="input-group-text w-25 d-flex justify-content-center">unidades</span>
                            </div>
                        </div>
                        <div class="mt-3"> 
                            <label for="contenidoPorUnidad">Contenido por Unidad</label>
                            <div class="input-group">
                                <input type="number" name="contenidoPorUnidad" id="contenidoPorUnidad" value="{{ old('contenidoPorUnidad') }}" 
                                class="form-control contenidoPorUnidad" required>
                                <span class="input-group-text w-25 d-flex justify-content-center">gramos</span>
                            </div>    
                        </div>
                        <div class="mt-3">
                            <label for="fechaElaboracion">Fecha de Elaboración</label>
                            <input type="date" name="fechaElaboracion" id="fechaElaboracion" value="{{ old('fechaElaboracion') }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label>Foto</label>
                        @include('_partials.dropzone')
                    </div>
                </div>
                <br><br>
                
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







