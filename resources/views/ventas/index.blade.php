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
                        <label for="cliente">Cliente:</label>
                        <input type="text" name="cliente" id="cliente" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha">Fecha:</label>
                        <input type="date" name="fecha" id="fecha" class="form-control" required>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-semibold mb-3">
                    <i class="bi bi-cart-plus me-2"></i>Agregar Productos
                </h6>
                <div class="card card-body bg-light border-0 mb-3">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label for="producto" class="form-label fw-medium">Producto:</label>
                            <input type="text" name="producto" id="producto" class="form-control" autocomplete="off" placeholder="Buscar producto..." required>
                            <input type="hidden" id="idProducto">
                            <ul id="lista-productos" class="list-group position-absolute shadow" style="z-index: 1000; max-height: 200px; overflow-y: auto;"></ul>
                        </div>
                        <div class="col-md-4">
                            <label for="cantidad" class="form-label fw-medium">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control" min="1" value="1" required>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="btn-agregar" class="btn btn-primary w-100 h-100" style="min-height: 37px;">
                                <i class="bi bi-plus-lg"></i> Agregar al Carrito
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <h6 class="fw-semibold mb-3">Carrito de Compras</h6>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle" id="tabla-carrito">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th style="width: 150px;">Cantidad</th>
                                    <th style="width: 100px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="carrito-body">
                                <tr id="fila-vacia">
                                    <td colspan="3" class="text-center text-muted py-4">No hay productos agregados</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <input type="hidden" name="carrito" id="carrito-input">
            </form>
        @endslot

        @slot('footer')
            <div class="row g-3">
                <div class="col-md-12">
                    <button type="button" id="btn-registrar" class="btn btn-success w-100">
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

