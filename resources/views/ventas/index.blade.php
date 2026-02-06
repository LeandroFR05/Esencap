@extends('layouts.admin')
@section('page', 'Ventas')
@section('content')

    <h2 style="text-align: center;">
        VENDER
    </h2>
    
    <form action="{{ route('ventas.store') }}" method="POST" style="max-width: 400px; margin: auto;">
        @csrf
        <label for="producto">Producto:</label>
        <input type="text" name="producto" id="producto" class="form-control" required>
        <input type="hidden" name="idProducto" id="idProducto">
        <ul id="lista-productos" class="list-group"></ul>
        <br>
        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" class="form-control" required>
        <br>
        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" id="fecha" class="form-control" required>
        <br>
        <button type="submit" class="btn btn-success form-control">Registrar Venta</button>
    </form>

@endsection


@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


@section('scripts')
    <script src="{{ asset('js/ventas/registrarVenta.js') }}"></script>
@endsection



<!-- Función para cargar el historial de ventas del producto seleccionado -->
<!-- function cargarHistorial(idProducto) { -->
        <!-- historialSelect.innerHTML = '';

        fetch(`/ventas/historial/${idProducto}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.idHistorial;
                option.textContent = `Fecha: ${item.fechaElaboracion} - Stock: ${item.stock}`;
                historialSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error(error);
        });  -->
<!-- } -->
     

