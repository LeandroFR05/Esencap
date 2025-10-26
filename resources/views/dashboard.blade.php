@extends('layouts.app')

@section('title', 'Dashboard')
@section('content')
    <h1>Bienvenido</h1>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Cerrar Sesión</button>
    </form>
@endsection