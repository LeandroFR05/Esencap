@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
    <h1>Bienvenido</h1>

    <a href="{{ route('lotes.infoVencimientos') }}">Lotes próximos a vencerse</a>
    <br>
    <a href="{{ route('lotes.infoStock') }}">Lotes con bajo stock</a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>
@endsection