<!-- PLANTILLA -->
@extends('layouts.admin')

@section('page', 'Ventas')

@section('title')
    {{ Breadcrumbs::render('ventas') }}
@endsection

@section('styles')
    @vite('resources/css/Productos/estCreate.css')
    @vite('resources/css/estTablas.css')
    <style>
        .detalle-title {
            padding: 1rem 1.25rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 8px;
            border-left: 4px solid #0e9100;
        }
    </style>
@endsection

<!-- CONTENIDO -->
@section('content')
    <form id="form-venta" action="{{ route('ventas.store') }}" method="POST">
        @csrf
        @component('components.cards')
            @slot('titulo')
                <small><i class="bi bi-plus-circle me-2"></i></small>Nueva Venta
            @endslot
            @slot('contenido')
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="cliente" class="form-label fw-semibold">Cliente:</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="nav-icon bi bi-person"></i>
                            </span>
                            <input type="text" name="cliente" id="cliente" value="{{ old('cliente') }}" 
                                class="form-control @error('cliente') is-invalid @enderror" required>
                        </div>
                        @error('cliente')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="fecha" class="form-label fw-semibold">Fecha:</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-calendar"></i>
                            </span>
                            <input type="date" name="fecha" id="fecha" value="{{ old('fecha') }}" 
                            class="form-control @error('fecha') is-invalid @enderror" required>
                            @error('fecha')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-semibold mb-3">
                    <i class="bi bi-cart-plus me-2"></i>Agregar Productos
                </h6>
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="producto" class="form-label fw-medium">Producto:</label>
                        <input type="text" name="producto" id="producto" class="form-control" autocomplete="off" placeholder="Buscar producto..." required>
                        <input type="hidden" id="idProducto">
                        <ul id="lista-productos" class="list-group position-absolute shadow" style="z-index: 1000; max-height: 200px; overflow-y: auto;"></ul>
                    </div>
                    <div class="col-md-3">
                        <label for="cantidad" class="form-label fw-medium">Cantidad:</label>
                        <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="col-md-3">
                        <label for="precioUnitario" class="form-label fw-medium">Precio Unitario:</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" name="precioUnitario" id="precioUnitario" class="form-control" min="0" step="0.01" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="button" id="btn-agregar" class="btn btn-primary w-100 h-100" style="min-height: 37px;">
                            <i class="bi bi-plus-lg"></i> Agregar
                        </button>
                    </div>
                </div>
            @endslot
        @endcomponent
        <br>

        @component('components.cards')
            @slot('contenido')
                <h5 class="detalle-title mb-4">Detalle de venta</h5>
                <table id="tabla-carrito">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th style="width: 110px;">Cantidad</th>
                            <th style="width: 130px;">Precio Unitario</th>
                            <th style="width: 130px;">Subtotal</th>
                            <th style="width: 100px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="carrito-body">
                        <tr id="fila-vacia">
                            <td colspan="5" class="text-center text-muted py-4">No hay productos agregados</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-semibold">Total general:</td>
                            <td class="fw-bold" id="total-general">$ 0.00</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

                <input type="hidden" name="carrito" id="carrito-input">
                <input type="hidden" id="carrito-old" value="{{ session('carrito') ? json_encode(session('carrito')) : old('carrito') }}">
            @endslot
        @endcomponent
    </form><br>

    @component('components.cards')
        @slot('contenido')
            <button type="button" id="btn-submit" class="btn w-100">
                <i class="bi bi-check-lg"></i> Registrar Venta
            </button>
        @endslot
    @endcomponent
@endsection


@section('scripts')
    <script src="{{ asset('js/ventas/registrarVenta.js') }}"></script>
@endsection

