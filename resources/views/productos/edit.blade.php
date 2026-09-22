<!-- PLANTILLA -->
@extends('layouts.admin')

@section('page', 'Editar Producto')

@section('title')
    {{ Breadcrumbs::render('editar', $producto) }}
@endsection

@section('styles')
    @vite('resources/css/Productos/estCreate.css')
@endsection

<!-- CONTENIDO -->
@section('content')
    <form action="{{ route('productos.update', $producto->idProducto) }}" method="POST" id="updateForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-3 justify-content-center">
            @component('components.cards-formCreate')
                @slot('titulo')
                    <i class="bi bi-pencil-square me-2"></i>Editar {{ $producto->nombre }}
                @endslot

                @slot('contenido')
                    <div class="row g-4">
                        <!-- Nombre -->
                        <div class="col-md-6">
                            <x-input-group 
                                name="nombre" 
                                label="Nombre" 
                                type="text" 
                                icon="bi-tag" 
                                value="{{ $producto->nombre }}" 
                                required 
                            />
                        </div>
                        <!-- Última elaboración -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <x-input-group
                                    name="ultimaElaboracion"
                                    label="Última elaboración"
                                    type="text"
                                    icon="bi-calendar-event"
                                    value="{{ $ultimaElaboracion }}"
                                    readonly
                                />
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Stock total -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="stock" class="form-label fw-semibold">
                                    Stock total
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-box"></i>
                                    </span>

                                    <input type="number"
                                        name="stock"
                                        id="stock"
                                        value="{{ $stockTotal }}"
                                        class="form-control"
                                        readonly>
                                    <div class="unidad-container">
                                        <span class="unidad">
                                            unidades
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Contenido por unidad -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contenidoPorUnidad" class="form-label fw-semibold">
                                    Contenido por unidad
                                </label>

                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-droplet-fill"></i>
                                    </span>

                                    <input type="number"
                                        name="contenidoPorUnidad"
                                        id="contenidoPorUnidad"
                                        value="{{ $producto->contenidoPorUnidad }}"
                                        class="form-control"
                                        readonly>

                                    <div class="unidad-container">
                                        <span class="unidad">
                                            gramos
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Volumen total de lote -->
                    <div class="volumen-total-lote mb-3" aria-live="polite">
                        <div class="volumen-total-lote__descripcion">
                            <div class="volumen-total-lote__titulo">
                                <i class="bi bi-hourglass-split me-1"></i>
                                Volumen Total disponible
                            </div>
                            <small>Stock total x contenido por unidad</small>
                        </div>
                        <div class="volumen-total-lote__valor">
                            <span id="volumenTotal">0</span>
                            <small>gramos</small>
                        </div>
                    </div>
                    <!-- Botón Ver lotes -->
                    <div class="mb-2 mt-2">
                        <a href="{{ route('productos.lotes', $producto->idProducto) }}"
                        class="btn btn-outline-info w-100">
                            <i class="bi bi-clock-history me-1"></i>
                            Ver lotes
                        </a>
                    </div>

                @endslot
            @endcomponent

            <!-- Foto -->
            @component('components.cards-foto')
                @slot('titulo')
                    <i class="bi bi-image me-2"></i>Foto
                @endslot
                @slot('contenido')
                    <input type="hidden" name="remove_foto" id="remove-foto" value="0">
                    @include('_partials.dropzone', ['foto' => $producto->foto])
                @endslot
            @endcomponent
        </div><br>
    </form>

    @component('components.cards')
        @slot('contenido')
            <div class="row g-3">
                <div class="col-md-8">
                    <button type="submit" class="btn btn-success w-100" form="updateForm">
                        <i class="bi bi-check-circle me-1"></i>Guardar cambios
                    </button>
                </div>

                <div class="col-md-4">
                    <form action="{{ route('productos.destroy', $producto->idProducto) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger w-100 delete-btn">
                            <i class="bi bi-trash3-fill me-1"></i> Eliminar producto
                        </button>
                    </form>
                </div>
            </div>
        @endslot
    @endcomponent
@endsection

@section('scripts')
    <script src="{{ asset('js/removerImagenDropzone.js') }}"></script>
    <script src="{{ asset('js/confirmarEliminacion.js') }}"></script>
    <script src="{{ asset('js/productos/calcularVolumenTotal.js') }}"></script>
@endsection
