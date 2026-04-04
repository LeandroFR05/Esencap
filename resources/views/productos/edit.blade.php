@extends('layouts.admin')
@section('page', 'Editar Producto')
@section('title')
    {{ Breadcrumbs::render('editar', $producto) }}
@endsection

@section('content')
    @component('components.cards')
        @slot('titulo', 'Editar ' . $producto->nombre)
        @slot('contenido')
            <!-- FORMULARIO -->
            <form action="{{ route('productos.update', $producto->idProducto) }}" method="POST" id="updateForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <!-- Datos iniciales -->
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" value="{{ $producto->nombre }}" class="form-control @error('nombre') is-invalid @enderror" required>
                        <div class="mt-3">
                            <label for="stock">Stock total:</label>
                            <div class="input-group">
                                <input type="number" name="stock" value="{{ $stockTotal }}" class="form-control" 
                                style="background-color: #f3f3f3ff;" readonly>
                                <span class="input-group-text w-25 d-flex justify-content-center">unidades</span>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="contenidoPorUnidad">Contenido por Unidad:</label>
                            <div class="input-group">
                                <input type="number" name="contenidoPorUnidad" value="{{ $producto->contenidoPorUnidad }}" 
                                class="form-control" style="background-color: #f3f3f3ff;" readonly>
                                <span class="input-group-text w-25 d-flex justify-content-center">gramos</span>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('productos.historial', $producto->idProducto) }}" 
                            class="btn btn-outline-info w-100">
                                Historial
                            </a>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="foto">Foto:</label>
                        <input type="hidden" name="remove_foto" id="remove-foto" value="0">
                        @include('_partials.dropzone', ['foto' => $producto->foto])
                    </div>
                </div>
            </form>
        @endslot

        @slot('footer')
            <!-- Enviar formulario -->
            <div class="row g-3">
                <div class="col-md-8">
                    <button type="submit" class="btn btn-success w-100" form="updateForm">Guardar</button>
                </div>
                <div class="col-md-4">
                    <form action="{{ route('productos.destroy', $producto->idProducto) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100 delete-btn">
                            <i class="bi bi-trash3-fill"></i> Eliminar
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