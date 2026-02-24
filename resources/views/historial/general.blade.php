@extends('layouts.admin')
@section('page', 'Historial')
@section('title')
    {{ Breadcrumbs::render('historialGeneral') }}
@endsection
@section('content')

<div class="container">

    <div class="card">
        <div class="card-header">Historial de Elaboración</div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="producto">Producto</label>
                    <input type="text" id="producto" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-secondary w-100" onclick="limpiarFiltros()">
                        Limpiar Filtros
                    </button>
                </div>
            </div>

            <table class="table table-bordered table-hover" id="tableHistorial">
                <thead class="table-dark">
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Stock</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historial as $h)
                        <tr>
                            <td>{{ $h->fechaElaboracion }}</td>
                            <td>{{ $h->producto->nombre }}</td>
                            <td>{{ $h->stock }}</td>
                            <td>
                                <button 
                                    class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalHistorial-{{ $h->idHistorial }}">
                                    Ver detalle
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@include('historial.modals.detalle_historial')

<div class="d-flex justify-content-center mt-3">
    {{ $historial->links() }}
</div>


@endsection


@section('scripts')
<script>
    document.getElementById("producto").addEventListener("input", filterTable);
    document.getElementById("fecha").addEventListener("change", filterTable);

    function filterTable() {
        // 1. Obtener los valores de ambos filtros
        const filtroProducto = document.getElementById("producto").value.trim().toLowerCase();
        const filtroFecha = document.getElementById("fecha").value; // Formato YYYY-MM-DD
        
        const rows = document.querySelectorAll("#tableHistorial tbody tr");

        rows.forEach(row => {
            const cells = row.getElementsByTagName("td");
            
            // 2. Extraer los datos de las celdas (Fecha es índice 0, Producto es índice 1)
            const textoFecha = cells[0].textContent.trim();
            const textoProducto = cells[1].textContent.trim().toLowerCase();

            // 3. Lógica de validación (Criterio Cruzado)
            // La fila se muestra solo si cumple AMBAS condiciones
            const coincideProducto = textoProducto.includes(filtroProducto);
            const coincideFecha = (filtroFecha === "" || textoFecha === filtroFecha);

            if (coincideProducto && coincideFecha) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    function limpiarFiltros() {
        // 1. Buscamos los inputs por su ID y los vaciamos
        document.getElementById("producto").value = "";
        document.getElementById("fecha").value = "";

        // 2. Ejecutamos la función de filtrado para que, 
        // al estar vacíos los inputs, se muestren todas las filas de nuevo.
        filterTable();
    }
    
</script>
@endsection