@extends('layouts.app')

@section('title', 'Detalle del Lote')
@section('content')

    <h1>Lotes de insumos</h1>
    <table class="table table-striped"> 
        <thead>
            <tr class="table-secondary">
                <th scope="col">Número de lote</th>
                <th scope="col">Stock</th>
                <th scope="col">Fecha de vencimiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lote as $item)
                <tr class="table-secondary">
                    <td>{{ $item->numeroLote }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>{{ $item->fechaVencimiento}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('insumos.estante') }}" class="btn btn-danger">Volver atrás</a>
    
@endsection