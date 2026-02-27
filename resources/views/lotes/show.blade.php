@extends('layouts.admin')
@section('page', 'Lotes')
@section('title')
    {{ Breadcrumbs::render('lotes', $insumo) }}
@endsection
@section('content')

    @component('components.cards')
        @slot('titulo', 'Lotes de ' . $insumo->nombre)

        @slot('contenido')
            @forelse($lote as $item)
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Número de lote</th>
                            <th scope="col">Stock Inicial</th>
                            <th scope="col">Stock Actual</th>
                            <th scope="col">Fecha de compra</th>
                            <th scope="col">Fecha de vencimiento</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lote as $item)
                            <tr>
                                <td>{{ $item->numeroLote }}</td>
                                <td>{{ $item->stockInicial }}gr</td>
                                <td>{{ $item->stockActual }}gr</td>
                                <td>{{ $item->fechaCompra}}</td>
                                <td>{{ $item->fechaVencimiento}}</td>
                                <td>
                                    <form action="{{ route('lotes.eliminar', $item->idLote) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="idInsumo" value="{{ $insumo->idInsumo }}">
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
            @empty
                <h6 style="display: flex; justify-content: center;">No existen lotes para este insumo</h6>
            @endforelse
        @endslot

        @slot('footer')
        @endslot
    @endcomponent
    
@endsection