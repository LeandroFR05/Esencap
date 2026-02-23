@extends('layouts.admin')
@section('page', 'Lotes')
@section('content')

    @component('components.cards')
        @slot('titulo', 'Lotes de ' . $nombreInsumo)

        @slot('contenido')
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Número de lote</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Fecha de vencimiento</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lote as $item)
                        <tr>
                            <td>{{ $item->numeroLote }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>{{ $item->fechaVencimiento}}</td>
                            <td>
                                <form action="{{ route('lotes.eliminar', $item->idLote) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash3-fill d-flex align-items-center justify-content-center"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endslot

        @slot('footer')
            <a href="{{ route('insumos.estante') }}" class="btn btn-danger">Volver atrás</a>
        @endslot
    @endcomponent
    
@endsection