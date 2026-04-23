@extends('layouts.admin')
@section('page', 'Editar Producto')

@section('title')
    {{ Breadcrumbs::render('editar', $producto) }}
@endsection

@section('content')
    @component('components.cards')

        @slot('titulo')
            <i class="bi bi-pencil-square me-2"></i>
            Editar {{ $producto->nombre }}
        @endslot

        @slot('contenido')
            <form action="{{ route('productos.update', $producto->idProducto) }}"
                method="POST"
                id="updateForm"
                enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-12 col-md-4">
                        <div class="mb-3">
                            <label for="nombre" class="form-label fw-semibold">
                                Nombre
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-tag"></i>
                                </span>

                                <input type="text"
                                    name="nombre"
                                    id="nombre"
                                    value="{{ $producto->nombre }}"
                                    class="form-control @error('nombre') is-invalid @enderror"
                                    required>

                                @error('nombre')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4">
                        <div class="mb-3">
                            <label for="ultimaElaboracion" class="form-label fw-semibold">
                                Última elaboración
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar-event"></i>
                                </span>

                                <input type="text"
                                       name="ultimaElaboracion"
                                       id="ultimaElaboracion"
                                       value="{{ $ultimaElaboracion }}"
                                       class="form-control bg-light"
                                       readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-12 col-md-8">

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
                                       class="form-control bg-light"
                                       readonly>

                                <span class="input-group-text w-25">
                                    unidades
                                </span>
                            </div>
                        </div>

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
                                       class="form-control bg-light"
                                       readonly>

                                <span class="input-group-text w-25">
                                    gramos
                                </span>
                            </div>
                        </div>

                        <div class="mb-3" style="margin-top: 40px;">
                            <a href="{{ route('productos.historial', $producto->idProducto) }}"
                               class="btn btn-outline-info w-100">
                                <i class="bi bi-clock-history me-1"></i>
                                Ver historial
                            </a>
                        </div>

                    </div>

                    <div class="col-12 col-md-4" style="margin-top: -60px;">
                        <div class="card border">
                            <div class="card-header bg-body-secondary">
                                <i class="bi bi-image me-2"></i>
                                Foto
                            </div>

                            <div class="card-body">

                                <input type="hidden"
                                       name="remove_foto"
                                       id="remove-foto"
                                       value="0">

                                @include('_partials.dropzone', ['foto' => $producto->foto])

                            </div>
                        </div>
                    </div>

                </div>
            </form>
        @endslot

        @slot('footer')
            <div class="row g-3">
                <div class="col-md-8">
                    <button type="submit"
                            class="btn btn-success w-100"
                            form="updateForm">
                        <i class="bi bi-check-circle me-1"></i>
                        Guardar cambios
                    </button>
                </div>

                <div class="col-md-4">
                    <form action="{{ route('productos.destroy', $producto->idProducto) }}"
                          method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-danger w-100 delete-btn">
                            <i class="bi bi-trash3-fill me-1"></i>
                            Eliminar
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
@endsection
