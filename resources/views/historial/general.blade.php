@extends('layouts.app')

@section('title', 'Historial General')
@section('content')

<div class="container">
    <h3 class="mb-4">Historial de elaboración</h3>

    <div>
        <label for="">Búsqueda:</label>
        <input type="text" id="searchInput" placeholder="Buscar por producto o fecha..." class="form-control" onkeyup="filterTable()">
    </div>

    <br>

    <table class="table table-bordered table-hover">
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

    @include('historial.modals.detalle_historial')

    <div class="d-flex justify-content-center mt-3">
        {{ $historial->links() }}
    </div>
    

@endsection