<!-- PLANTILLA -->
@extends('layouts.admin')

@section('page', 'Reponer Producto')

@section('title')
    {{ Breadcrumbs::render('reponerProducto', $producto) }}
@endsection

@section('styles')
    @vite('resources/css/Productos/estCreate.css')
    @vite('resources/css/Productos/estReponer.css')
@endsection

<!-- CONTENIDO -->
@section('content')
    <form id="formProductos" action="{{ route('productos.reponer.store', $producto->idProducto) }}" method="POST">
        @csrf
        @component('components.cards')
            @slot('titulo')<small><i class="bi bi-plus-square me-2"></i></small>Reponer {{ $producto->nombre }}@endslot
        
            @slot('contenido')
                <div class="row g-3 justify-content-center">

                    <!-- Stock Inicial -->
                    <div class="col-md-6 mb-3">
                        <label for="stockInicial" class="form-label fw-semibold">
                            Stock inicial
                        </label>

                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-box"></i></span>

                            <input type="number"
                                name="stockInicial"
                                id="stockInicial"
                                class="form-control stockInicial @error('stockInicial') is-invalid @enderror"
                                value="{{ old('stockInicial') }}"
                                min="1" max="99999"
                                required>
                            <div class="unidad-container">
                                <span class="unidad">unidades</span>
                            </div>

                            @error('stockInicial')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Contenido por Unidad -->
                    <div class="col-md-6 mb-3">
                        <label for="contenidoPorUnidad" class="form-label fw-semibold">
                            Contenido por Unidad
                        </label>

                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-archive"></i></span>

                            <input type="number"
                                name="contenidoPorUnidad"
                                id="contenidoPorUnidad"
                                value="{{ $producto->contenidoPorUnidad }}"
                                class="form-control contenidoPorUnidad @error('contenidoPorUnidad') is-invalid @enderror"
                                readonly
                                required>
                            <div class="unidad-container">
                                <span class="unidad">gramos</span>
                            </div>

                            @error('contenidoPorUnidad')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row g-3 justify-content-center">
                    <!-- Volumen total de lote -->
                    <div class="col-md-6">
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
                    </div>

                    <!-- Fecha de Elaboración -->
                    <div class="col-md-6">
                        <label for="fechaElaboracion" class="form-label fw-semibold">
                            Fecha de elaboración
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-calendar-date"></i>
                            </span>

                            <input type="date"
                                name="fechaElaboracion"
                                id="fechaElaboracion"
                                class="form-control @error('fechaElaboracion') is-invalid @enderror"
                                value="{{ old('fechaElaboracion') }}"
                                required>

                            @error('fechaElaboracion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endslot
        @endcomponent
        <br>

        <!-- FÓRMULA -->
        @component('components.cards')
            @slot('contenido')
                <p>Última Elaboración</p>
                @include('_partials.productos.estrFormula1')
                <div id="contenedor-formulas">
                    @php
                        $oldPorcentajes = old('porcentaje', null);
                        $oldFamilias = old('familia', []);
                        $oldInsumos = old('insumo', []);
                        $oldContenidos = old('contenido', []);

                        $filasRender = [];
                        if ($oldPorcentajes !== null) {
                            foreach($oldPorcentajes as $index => $porcentaje) {
                                $filasRender[] = [
                                    'porcentaje' => $porcentaje,
                                    'idFamilia' => $oldFamilias[$index] ?? null,
                                    'idInsumo' => $oldInsumos[$index] ?? null,
                                    'contenido' => isset($oldContenidos[$index]) && $oldContenidos[$index] !== '' ? number_format((float) $oldContenidos[$index], 2, '.', '') : '',
                                ];
                            }
                        } else {
                            foreach($lote->formulas as $fila) {
                                $filasRender[] = [
                                    'porcentaje' => $fila->porcentaje,
                                    'idFamilia' => $fila->insumo->familia->idFamilia ?? null,
                                    'idInsumo' => $fila->insumo->idInsumo ?? null,
                                    'contenido' => number_format((float) $fila->contenido, 2, '.', ''),
                                ];
                            }
                        }
                    @endphp
                    
                    @foreach($filasRender as $filaRender)
                        @php
                            $selectedFamilia = $filaRender['idFamilia'];
                            $selectedInsumo = $filaRender['idInsumo'];
                            $familiaObj = $familias->firstWhere('idFamilia', $selectedFamilia);
                            $insumosPorFamilia = $familiaObj ? $familiaObj->insumos : collect();
                        @endphp
                        <div class="row formula-item g-3 mb-2 align-items-center">
                            <!-- Porcentaje -->
                            <div class="col">
                                <div class="input-group">
                                    <input type="number" 
                                           name="porcentaje[]" 
                                           value="{{ $filaRender['porcentaje'] }}" 
                                           class="form-control form-control-sm porcentaje" 
                                           placeholder="0.00"
                                           step="0.01"
                                           min="1" max="99999.99"
                                           required>
                                    <span class="input-group-text w-25 d-flex justify-content-center"><small>%</small></span>   
                                </div>
                            </div>
                            <!-- Familia -->
                            <div class="col">
                                <select name="familia[]" class="form-select form-select-sm select-familia" required>
                                    <option value="">Seleccione una familia</option>
                                    @foreach($familias as $familia)
                                        <option value="{{ $familia->idFamilia }}"
                                            @selected($familia->idFamilia == $selectedFamilia)>
                                            {{ $familia->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Contenido -->
                            <div class="col">
                                <div class="input-group">
                                    <input type="number" 
                                           name="contenido[]" 
                                           value="{{ $filaRender['contenido'] }}" 
                                           class="form-control form-control-sm contenido" 
                                           step="0.01" 
                                           readonly>
                                    <span class="input-group-text w-25 d-flex justify-content-center"><small>gr</small></span>
                                </div>
                            </div>
                            <!-- Insumo -->
                            <div class="col">
                                <select name="insumo[]" class="form-select form-select-sm select-insumo" required>
                                    <option value="">Seleccione un insumo</option>
                                    @foreach($insumosPorFamilia as $insumo)
                                        <option value="{{ $insumo->idInsumo }}" @selected($insumo->idInsumo == $selectedInsumo)>
                                            {{ $insumo->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Botón eliminar -->
                            <div class="col">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-eliminar">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="formula-actions mt-4">
                    <div class="flex-wrap" aria-live="polite">
                        <div class="suma-total-porcentaje">
                            <div class="suma-total-porcentaje__titulo">Suma total de porcentaje:</div>
                            <div class="suma-total-porcentaje__valor">
                                <span id="sumaTotalPorcentaje">0</span> %
                            </div>
                        </div>
                        <div id="error-porcentaje" class="text-danger w-100 mt-2" style="display: none; font-size: 13px; font-weight: 600;">
                            La suma de porcentajes debe ser 100%.
                        </div>
                    </div>
                    <button type="button" id="btn-agregar" class="btn btn-outline-primary align-self-start">
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
                    <i class="bi bi-floppy me-1"></i> Guardar
                </button>
            @endslot
        @endcomponent
    </form>
@endsection


@section('scripts')
    @include('_partials.productos.scripts')
@endsection
