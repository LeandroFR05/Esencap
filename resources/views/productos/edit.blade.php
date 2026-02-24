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
            <form action="{{ route('productos.update', $producto->idProducto) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <!-- Datos iniciales -->
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" value="{{ $producto->nombre }}" class="form-control" required>
                        <div class="mt-3">
                            <label for="stock">Stock total:</label>
                            <input type="number" name="stock" value="{{ $stockTotal }}" class="form-control" 
                            style="background-color: #f3f3f3ff;" readonly>
                        </div>
                        <div class="mt-3">
                            <label for="contenidoPorUnidad">Contenido por Unidad:</label>
                            <input type="number" name="contenidoPorUnidad" value="{{ $producto->contenidoPorUnidad }}" 
                            class="form-control" style="background-color: #f3f3f3ff;" readonly>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="foto">Foto:</label>
                        <input type="hidden" name="remove_foto" id="remove-foto" value="0">
                        @include('_partials.dropzone', ['foto' => $producto->foto])
                    </div>
                </div>
                <!-- Enviar formulario -->
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="mt-4">
                            <button type="submit" class="btn btn-success w-100">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        @endslot

        @slot('footer')
            
        @endslot
    @endcomponent

@endsection


@section('scripts')
    <script src="{{ asset('js/removerImagenDropzone.js') }}"></script>
@endsection