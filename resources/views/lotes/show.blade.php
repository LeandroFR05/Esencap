@extends('layouts.app')

@section('title', 'Detalle del Lote')
@section('content')
    <h1>Lotes de insumos</h1>
    <ul>
        @foreach($lote as $item)
            <li>{{ $item->stock }} - {{ $item->fechaVencimiento }}</li>
        @endforeach
    </ul>
@endsection