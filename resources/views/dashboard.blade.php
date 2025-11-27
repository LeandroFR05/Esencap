@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')

    <!--INSUMOS-->
    <a href="{{ route('insumos.create') }}"><i class="bi bi-plus-lg"></i> Nuevo Insumo</a>
    <br>

    <!--LOTES-->
    <a href="{{ route('lotes.infoVencimientos') }}">Lotes próximos a vencerse</a>
    <br>
    <a href="{{ route('lotes.infoStock') }}">Lotes con bajo stock</a>

    <!--CERRAR SESIÓN-->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"><i class="bi bi-box-arrow-left"></i> Cerrar Sesión</button>
    </form>
@endsection