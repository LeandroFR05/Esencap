@extends('layouts.admin')
@section('page', 'Ventas')
@section('title')
    {{ Breadcrumbs::render('ventas') }}
@endsection

@section('content')
    @component('components.cards')
        @slot('titulo', 'Nueva Venta')
        @slot('contenido')
            <form id="form-venta" action="{{ route('ventas.store') }}" method="POST">
                @csrf
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
                <div class="card card-body bg-light border-0 mb-3">
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
                </div>

                <div class="mt-4">
                    <h6 class="fw-semibold mb-3">Detalle de venta</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle" id="tabla-carrito">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th style="width: 110px;">Cantidad</th>
                                    <th style="width: 130px;">Precio Unitario</th>
                                    <th style="width: 130px;">Total</th>
                                    <th style="width: 100px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="carrito-body">
                                <tr id="fila-vacia">
                                    <td colspan="5" class="text-center text-muted py-4">No hay productos agregados</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr class="table-light">
                                    <td colspan="3" class="text-end fw-semibold">Total general:</td>
                                    <td class="fw-bold" id="total-general">$ 0.00</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <input type="hidden" name="carrito" id="carrito-input">
                <input type="hidden" id="carrito-old" value="{{ session('carrito') ? json_encode(session('carrito')) : old('carrito') }}">
            </form>
        @endslot

        @slot('footer')
            <div class="row g-3">
                <div class="col-12 d-flex justify-content-end">
                    <button type="button" id="btn-registrar" class="btn btn-success w-25">
                        <i class="bi bi-check-lg"></i> Registrar Venta
                    </button>
                </div>
            </div>
        @endslot
    @endcomponent
@endsection


@section('scripts')
    <script src="{{ asset('js/ventas/registrarVenta.js') }}"></script>
@endsection

