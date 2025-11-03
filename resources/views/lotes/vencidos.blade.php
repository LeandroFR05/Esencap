@extends('layouts.app')

@section('title', 'Lotes próximos a vencerse')
@section('content')

    <h1>Lotes próximos a vencerse</h1>

    @if($lotesVencidos->isEmpty())
        <li>No hay lotes próximos a vencerse.</li>
    @else
        <table class="table table-danger"> 
            <thead>
                <tr class="table table-danger">
                    <th scope="col">Número de lote</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Fecha de vencimiento</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lotesVencidos as $lote)
                    <tr class="table table-danger">
                        <td>{{ $lote->numeroLote }}</td>
                        <td>{{ $lote->stock }}</td>
                        <td>{{ $lote->fechaVencimiento}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    
@endsection