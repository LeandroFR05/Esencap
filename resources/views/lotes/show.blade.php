@extends('layouts.admin')
@section('page', 'Lotes')
@section('content')

    @component('_components.cards')
        @slot('titulo', 'Lotes de insumos')

        @slot('contenido')
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Número de lote</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Fecha de vencimiento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lote as $item)
                        <tr>
                            <td>{{ $item->numeroLote }}</td>
                            <td>{{ $item->stock }}</td>
                            <td>{{ $item->fechaVencimiento}}</td>
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