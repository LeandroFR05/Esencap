@extends('layouts.admin')
@section('page', 'Historial')
@section('title')
    {{ Breadcrumbs::render('historialGeneral') }}
@endsection

@section('content')

    @component('components.cards')
        @slot('titulo', 'Historial de elaboración')
        @slot('contenido')
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

            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="tableHistorial">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Producto</th>
                            <th>Stock inicial</th>
                            <th>Stock actual</th>
                            <th>Contenido por unidad</th>
                            <th style="width: 120px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($historial as $h)
                            <tr>
                                <td>{{ $h->fechaElaboracion }}</td>
                                <td>{{ $h->producto->nombre }}</td>
                                <td>{{ $h->stockInicial }}u</td>
                                <td>{{ $h->stockActual }}u</td>
                                <td>{{ $h->producto->contenidoPorUnidad }}gr</td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <button 
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalHistorial-{{ $h->idHistorial }}">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                        <form action="{{ route('historial.eliminar', $h->idHistorial) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="idProducto" value="{{ $h->producto->idProducto }}">
                                            <button type="submit"
                                                class="btn btn-sm btn-danger delete-btn">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endslot
        @slot('footer')
            <div class="d-flex justify-content-center mt-3">
                {{ $historial->links() }}
            </div>
        @endslot
    @endcomponent


    @include('historial.modals.detalle_historial')

@endsection


@section('scripts')
    <script src="{{ asset('js/historial/filtros_historial.js') }}"></script>
    <script src="{{ asset('js/confirmarEliminacion.js') }}"></script>
@endsection