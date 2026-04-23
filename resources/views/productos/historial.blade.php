@extends('layouts.admin')
@section('page', 'Historial del Producto')

@section('title')
    {{ Breadcrumbs::render('historialProducto', $producto) }}
@endsection

@section('content')

@component('components.cards')

    @slot('titulo')
        <i class="bi bi-clock-history me-2"></i>
        Historial de elaboración de {{ $producto->nombre }}
    @endslot


    @slot('contenido')

        @if ($producto->historiales->isEmpty())

            <div class="alert alert-info mb-0">
                <i class="bi bi-info-circle me-2"></i>
                No hay historial de elaboraciones para este producto.
            </div>

        @else

            <div class="table-responsive">

                <table
                    class="table table-bordered table-hover align-middle text-nowrap"
                    id="tableHistorial"
                >

                    <thead class="table-dark">

                        <tr class="text-center">

                            <th class="fw-semibold">
                                Fecha de Elaboración
                            </th>

                            <th class="fw-semibold">
                                Stock inicial
                            </th>

                            <th class="fw-semibold">
                                Stock actual
                            </th>

                            <th class="fw-semibold">
                                Contenido por unidad
                            </th>

                            <th
                                class="fw-semibold text-center"
                                style="width: 120px;"
                            >
                                Acciones
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($producto->historiales as $historial)

                            <tr>

                                <td>
                                    {{ \Carbon\Carbon::parse($historial->fechaElaboracion)->format('d/m/Y') }}
                                </td>

                                <td class="text-center">
                                    {{ $historial->stockInicial }}u
                                </td>

                                <td class="text-center">

                                    <span class="badge bg-success">

                                        {{ $historial->stockActual }}u

                                    </span>

                                </td>

                                <td class="text-center">
                                    {{ $producto->contenidoPorUnidad }}gr
                                </td>

                                <td>

                                    <div class="d-flex justify-content-center gap-2">

                                        <!-- Ver detalle -->
                                        <button
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalHistorialProd-{{ $historial->idHistorial }}"
                                            data-toggle="tooltip"
                                            title="Ver detalle"
                                        >
                                            <i class="bi bi-eye-fill"></i>
                                        </button>

                                        <!-- Eliminar -->
                                        <form
                                            action="{{ route('historial.eliminar', $historial->idHistorial) }}"
                                            method="POST"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <input
                                                type="hidden"
                                                name="idProducto"
                                                value="{{ $producto->idProducto }}"
                                            >

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-danger delete-btn"
                                                data-toggle="tooltip"
                                                title="Eliminar"
                                            >
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

                            <td colspan="2" class="text-end">
                                Stock Total:
                            </td>

                            <td class="text-center">

                                <span class="badge bg-primary">

                                    {{ $producto->historiales->sum('stockActual') }}u

                                </span>

                            </td>

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

            <a
                href="{{ route('productos.reponer', $producto->idProducto) }}"
                class="btn btn-success"
            >

                <i class="bi bi-plus-lg me-1"></i>

                Reponer

            </a>

        </div>

    @endslot

@endcomponent


@include('productos.modals.detalle_historial')

@endsection


@section('scripts')

<script src="{{ asset('js/confirmarEliminacion.js') }}"></script>

@endsection
