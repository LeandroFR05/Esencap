@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')

    <h1>Iniciar Sesión</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label for="name"><i class="bi bi-person"></i></label>
            <input type="text" name="name" placeholder="Usuario" required>
        </div>
        <div>
            <label for="password"><i class="bi bi-lock"></i></label>
            <input type="password" name="password" placeholder="Contraseña" required>
        </div>
        <div>
            <button type="submit" class="btn btn-success">ACCEDER</button>
        </div>
    </form>

@endsection