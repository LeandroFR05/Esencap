<!-- PLANTILLA -->
@extends('layouts.admin')

@section('page', 'Nuevo Producto')

@section('title')
    {{ Breadcrumbs::render('nuevo') }}
@endsection

@section('styles')
    @vite('resources/css/Productos/estCreate.css')
@endsection

<!-- CONTENIDO -->
@section('content')
    <form id="formProductos" method="POST" action="{{ route('productos.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3 justify-content-center">
            @component('components.cards-formCreate')
                @slot('titulo')
                    <small><i class="bi bi-flask me-2"></i></small>Información de Producción
                @endslot
                @slot('contenido')
                    <!-- Nombre -->
                    <div class="mb-3">
                    <x-input-group 
                        name="nombre"
                        label="Nombre"
                        type="text"
                        icon="bi-tag"
                        value="{{ old('nombre') }}"
                        required
                    />
                    </div>

                    <div class="row g-3 justify-content-center">
                        <!-- Stock inicial -->
                        <div class="col-md-6">
                            <label for="stockInicial" class="form-label fw-semibold">
                                Stock inicial
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-box"></i>
                                </span>
                                <input type="number" name="stockInicial" id="stockInicial" value="{{ old('stockInicial') }}"
                                    class="form-control stockInicial" required>

                                <div class="unidad-container">
                                    <span class="unidad">
                                        unidades
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!-- Contenido por Unidad -->
                        <div class="col-md-6 mb-3">
                            <label for="contenidoPorUnidad" class="form-label fw-semibold">
                                Contenido por Unidad
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-archive"></i>
                                </span>
                                <input type="number" name="contenidoPorUnidad" id="contenidoPorUnidad" value="{{ old('contenidoPorUnidad') }}"
                                    class="form-control contenidoPorUnidad" required>

                                <div class="unidad-container">
                                    <span class="unidad">
                                        gramos
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Volumen total de lote -->
                    <div class="volumen-total-lote mb-3" aria-live="polite">
                        <div class="volumen-total-lote__descripcion">
                            <div class="volumen-total-lote__titulo">
                                <i class="bi bi-hourglass-split me-1"></i>
                                Volumen Total del Lote
                            </div>
                            <small>Stock inicial x contenido por unidad</small>
                        </div>
                        <div class="volumen-total-lote__valor">
                            <span id="volumenTotal">0</span>
                            <small>gramos</small>
                        </div>
                    </div>

                    <!-- Fecha de Elaboración -->
                    <div class="mb-3">
                    <x-input-group
                        name="fechaElaboracion"
                        label="Fecha de Elaboración"
                        type="date"
                        icon="bi-calendar-date"
                        value="{{ old('fechaElaboracion') }}"
                        required
                    />
                    </div>
                @endslot
            @endcomponent

            <!-- Foto -->
            @component('components.cards-foto')
                @slot('titulo')
                    <small><i class="bi bi-image me-2"></small></i>Foto
                @endslot
                @slot('contenido')
                    @include('_partials.dropzone')
                @endslot
            @endcomponent
        </div><br>

        <!-- Fórmula -->
        @component('components.cards')
            @slot('contenido')
                <!-- FÓRMULA --> 
                @include('_partials.productos.estrFormula1')
                <!-- Si hay algún error, el usuario no pierde lo que ya escribió en la fórmula -->
                @php
                    $oldPorcentajes = old('porcentaje', []);
                    $oldFamilias = old('familia', []);
                    $oldInsumos = old('insumo', []);
                    $oldContenidos = old('contenido', []);
                @endphp
                <div id="contenedor-formulas">
                    @if(count($oldPorcentajes) > 0)
                        @foreach($oldPorcentajes as $index => $porcentaje)
                            @php
                                $selectedFamilia = $oldFamilias[$index] ?? null;
                                $selectedInsumo = $oldInsumos[$index] ?? null;
                                $insumosPorFamilia = $selectedFamilia && isset($insumos[$selectedFamilia]) ? $insumos[$selectedFamilia] : collect();
                            @endphp
                            <div class="row formula-item g-3 mb-2 align-items-center">
                                <!-- Porcentaje -->
                                <div class="col">
                                    <div class="input-group">
                                        <input type="number" name="porcentaje[]" class="form-control form-control-sm porcentaje" placeholder="0.00" value="{{ $porcentaje }}" step="0.01" required>
                                        <span class="input-group-text input-group-text-sm"><small>%</small></span>
                                    </div>
                                </div>
                                <!-- Familia -->
                                <div class="col">
                                    <select name="familia[]" class="form-select form-select-sm select-familia" required>
                                        <option value="">Seleccione una familia</option>
                                        @foreach($familias as $familia)
                                            <option value="{{ $familia->idFamilia }}" {{ $selectedFamilia == $familia->idFamilia ? 'selected' : '' }}>{{ $familia->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Contenido -->
                                <div class="col">
                                    <div class="input-group">
                                        <input type="number" name="contenido[]" 
                                            class="form-control form-control-sm contenido" readonly value="{{ isset($oldContenidos[$index]) && $oldContenidos[$index] !== '' ? number_format((float) $oldContenidos[$index], 2, '.', '') : '' }}" step="0.01">
                                        <span class="input-group-text input-group-text-sm"><small>gr</small></span>
                                    </div>
                                </div>
                                <!-- Insumo -->
                                <div class="col">
                                    <select name="insumo[]" class="form-select form-select-sm select-insumo" required>
                                        <option value="">Insumo</option>
                                        @foreach($insumosPorFamilia as $insumo)
                                            <option value="{{ $insumo->idInsumo }}" {{ $selectedInsumo == $insumo->idInsumo ? 'selected' : '' }}>{{ $insumo->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Eliminar -->
                                <div class="col">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row formula-item g-3 mb-2 align-items-center">
                            <!-- Porcentaje -->
                            <div class="col">
                                <div class="input-group">
                                    <input type="number" name="porcentaje[]" class="form-control form-control-sm porcentaje" placeholder="0.00" step="0.01" required>
                                    <span class="input-group-text input-group-text-sm"><small>%</small></span>
                                </div>
                            </div>
                            <!-- Familia -->
                            <div class="col">
                                <select name="familia[]" class="form-select form-select-sm select-familia" required>
                                    <option value="">Seleccione una familia</option>
                                    @foreach($familias as $familia)
                                        <option value="{{ $familia->idFamilia }}">{{ $familia->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Contenido -->
                            <div class="col">
                                <div class="input-group">
                                    <input type="number" name="contenido[]" class="form-control form-control-sm contenido" readonly>
                                    <span class="input-group-text input-group-text-sm"><small>gr</small></span>
                                </div>
                            </div>
                            <!-- Insumo -->
                            <div class="col">
                                <select name="insumo[]" class="form-select form-select-sm select-insumo" required>
                                    <option value="">Insumo</option>
                                </select>
                            </div>
                            <!-- Eliminar -->
                            <div class="col">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="formula-actions mt-4">
                    <div class="suma-total-porcentaje">
                        <div class="suma-total-porcentaje__titulo">Suma total de porcentaje:</div>
                        <div class="suma-total-porcentaje__valor">
                            <span id="sumaTotalPorcentaje">0</span> %
                        </div>
                    </div>
                    <button type="button" id="btn-agregar" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle me-2"></i>Agregar fila
                    </button>
                </div>
            @endslot
        @endcomponent
        <br>
        
        <!-- Enviar formulario -->
        @component('components.cards')
            @slot('contenido')
                <button type="submit" id="btn-submit" class="btn w-100">
                    <i class="bi bi-floppy me-1"></i> Guardar en el estante
                </button>
            @endslot
        @endcomponent
    </form>
    
@endsection

@section('scripts')
    @include('_partials.productos.scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>
@endsection







