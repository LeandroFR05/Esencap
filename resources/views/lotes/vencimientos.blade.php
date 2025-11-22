@extends('layouts.app')

@section('title', 'Vencimientos de Lotes')
@section('content')

    @if($lotesAgrupados->isEmpty())
        <li>No hay lotes próximos a vencerse.</li>
    @else
        <h1>Lotes próximos a vencerse</h1>
        @include('lotes.informacion')
    @endif

@endsection