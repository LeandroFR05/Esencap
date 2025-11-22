@extends('layouts.app')

@section('title', 'Stock de Lotes')
@section('content')

    @if($lotesAgrupados->isEmpty())
        <li>No hay lotes con bajo stock</li>
    @else
        <h1>Lotes con bajo stock</h1>
        @include('lotes.informacion')
    @endif

@endsection