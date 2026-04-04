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

                <style>
                    .formula-card {
                        background: #ffffff;
                        border: 1px solid #e2e8f0;
                        border-radius: 12px;
                        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                        transition: box-shadow 0.2s ease;
                    }

                    .formula-card:hover {
                        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
                    }

                    .formula-item .form-control,
                    .formula-item .form-select {
                        border-radius: 8px;
                        border: 1px solid #e2e8f0;
                        transition: border-color 0.2s, box-shadow 0.2s;
                        height: 31px;
                        padding-top: 0.375rem;
                        padding-bottom: 0.375rem;
                        box-sizing: border-box;
                    }

                    .formula-item .form-select {
                        line-height: 1.4;
                    }

                    .formula-item .input-group {
                        display: flex;
                    }

                    .formula-item .form-control:focus,
                    .formula-item .form-select:focus {
                        border-color: #0d6efd;
                        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
                    }

                    .formula-item .input-group-text {
                        background: #f8f9fa;
                        border: 1px solid #e2e8f0;
                        border-radius: 0 8px 8px 0;
                        font-size: 0.8rem;
                        font-weight: 500;
                        color: #6c757d;
                        height: 31px;
                        padding-top: 0.375rem;
                        padding-bottom: 0.375rem;
                        box-sizing: border-box;
                    }

                    .btn-outline-danger:hover {
                        background: #dc3545;
                        border-color: #dc3545;
                        color: white;
                    }
                </style>
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







