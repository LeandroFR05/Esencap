@extends('layouts.admin')
@section('page', 'Historial')
@section('title', 'Historial General')
@section('content')

<div class="container">

    <div class="card">
        <div class="card-header">Historial de Elaboración</div>
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="producto">Producto</label>
                    <input type="text" id="producto" class="form-control" onkeyup="filterTable()">
                </div>
                <div class="col-md-4">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" class="form-control">
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
    function filterTable() {
        const producto = document.getElementById("producto");
        const filter = producto.value.trim().toLowerCase();
        const rows = document.querySelectorAll("#tableHistorial tbody tr");

        rows.forEach(row => {
            const cells = row.getElementsByTagName("td");
            
            const productoText = cells[1].textContent.trim().toLowerCase();
            row.style.display = productoText.includes(filter) ? "" : "none";
        });
    }
</script>
@endsection