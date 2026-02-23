@extends('layouts.admin')
@section('page', 'Historial del Producto')

@section('content')

<div class="container">

    <div class="card">
        <div class="card-header">Historial de Elaboración de {{ $producto->nombre }}</div>
        <div class="card-body">
            @if ($producto->historiales->isEmpty())
                <p>No hay historial de elaboraciones para este producto.</p>
            @else
                <table class="table table-bordered table-hover" id="tableHistorial">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha de Elaboración</th>
                            <th>Stock disponible</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($producto->historiales as $historial)
                            <tr>
                                <td>{{ $historial->fechaElaboracion }}</td>
                                <td>{{ $historial->stock }}</td>
                                <td>
                                <button 
                                    class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalHistorialProd-{{ $historial->idHistorial }}">
                                    Ver detalle
                                </button>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

@include('productos.modals.detalle_historial')

@endsection