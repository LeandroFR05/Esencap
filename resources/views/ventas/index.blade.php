@extends('layouts.admin')
@section('page', 'Ventas')
@section('title')
    {{ Breadcrumbs::render('ventas') }}
@endsection

@section('content')
    @component('components.cards')
        @slot('titulo', 'Vender Producto')
        @slot('contenido')
            <form action="{{ route('ventas.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-12">
                        <label for="producto">Producto:</label>
                        <input type="text" name="producto" id="producto" class="form-control producto" required>
                        <input type="hidden" name="idProducto" id="idProducto">
                        <ul id="lista-productos" class="list-group"></ul>
                        <div class="mt-3"> 
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="cliente">Cliente:</label>
                            <input type="text" name="cliente" id="cliente" class="form-control" required>
                        <div class="mt-3"> 
                            <label for="fecha">Fecha:</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" required>
                        </div>
                    </div>
                </div>
        @endslot

        @slot('footer')
            <div class="row g-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success w-100">Registrar Venta</button>
                </div>
            </div>
        @endslot
            </form>

    @endcomponent

@endsection


@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


@section('scripts')
    <script src="{{ asset('js/ventas/registrarVenta.js') }}"></script>
@endsection

