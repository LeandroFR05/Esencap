@extends('layouts.admin')
@section('page', 'Historial del Producto')
@section('title')
    {{ Breadcrumbs::render('historialProducto', $producto) }}
@endsection

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
                            <th>Stock inicial</th>
                            <th>Stock actual</th>
                            <th>Contenido por unidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($producto->historiales as $historial)
                            <tr>
                                <td>{{ $historial->fechaElaboracion }}</td>
                                <td>{{ $historial->stockInicial }}u</td>
                                <td>{{ $historial->stockActual }}u</td>
                                <td>{{ $producto->contenidoPorUnidad }}gr</td>
                                <td class="d-flex justify-content-center align-items-center gap-2">
                                    <button
                                        class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalHistorialProd-{{ $historial->idHistorial }}">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    
                                    <form action="{{ route('historial.eliminar', $historial->idHistorial) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="idProducto" value="{{ $producto->idProducto }}">
                                        <button type="submit" class="btn btn-sm btn-danger delete-btn">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-secondary fw-bold">
                            <td colspan="2" class="text-end">Stock Total:</td>
                            <td>{{ $producto->historiales->sum('stockActual') }}u</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            @endif
            <div class="d-flex justify-content-end">
                <a href="{{ route('productos.reponer', $producto->idProducto) }}" 
                    class="btn btn-outline-success">
                    <i class="bi bi-plus-lg"></i>Reponer
                </a>
            </div>
        </div>
    </div>
</div>

@include('productos.modals.detalle_historial')

@endsection

@section('scripts')
    <script src="{{ asset('js/lotes/confirmarEliminacion.js') }}"></script>
@endsection