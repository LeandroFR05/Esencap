@extends('layouts.admin')
@section('page', 'Historial del Producto')
@section('title')
    {{ Breadcrumbs::render('historialProducto', $producto) }}
@endsection

@section('content')
    @component('components.cards')
        @slot('titulo', 'Historial de elaboración de ' . $producto->nombre . '')
        @slot('contenido')
            @if ($producto->historiales->isEmpty())
                <p>No hay historial de elaboraciones para este producto.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0" id="tableHistorial">
                        <thead class="table-dark">
                            <tr class="text-center">
                                <th class="fw-semibold">Fecha de Elaboración</th>
                                <th class="fw-semibold">Stock inicial</th>
                                <th class="fw-semibold">Stock actual</th>
                                <th class="fw-semibold">Contenido por unidad</th>
                                <th class="fw-semibold" style="width: 120px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($producto->historiales as $historial)
                                <tr>
                                    <td>{{ $historial->fechaElaboracion }}</td>
                                    <td>{{ $historial->stockInicial }}u</td>
                                    <td>{{ $historial->stockActual }}u</td>
                                    <td>{{ $producto->contenidoPorUnidad }}gr</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button
                                                class="btn btn-sm btn-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalHistorialProd-{{ $historial->idHistorial }}"
                                                data-toggle="tooltip"
                                                title="Ver detalle">
                                                <i class="bi bi-eye-fill"></i>
                                            </button>
                                            <form action="{{ route('historial.eliminar', $historial->idHistorial) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="idProducto" value="{{ $producto->idProducto }}">
                                                <button type="submit" class="btn btn-sm btn-danger delete-btn" data-toggle="tooltip" title="Eliminar">
                                                    <i class="bi bi-trash3-fill"></i>
                                                </button>
                                            </form>
                                        </div>
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
                </div>
            @endif
        @endslot
        @slot('footer')
            <div class="d-flex justify-content-end">
                <a href="{{ route('productos.reponer', $producto->idProducto) }}" 
                    class="btn btn-outline-success">
                    <i class="bi bi-plus-lg"></i>Reponer
                </a>
            </div>
        @endslot
    @endcomponent

    @include('productos.modals.detalle_historial')

@endsection

@section('scripts')
    <script src="{{ asset('js/confirmarEliminacion.js') }}"></script>
@endsection