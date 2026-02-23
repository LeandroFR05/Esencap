@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        
        <div class="card shadow" style="width: 100%; max-width: 400px;">
            <div class="card-header text-center bg-dark text-white">
                <h2 class="mb-0">Iniciar Sesión</h2>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input type="text" name="name" class="form-control" placeholder="Usuario" required>
                    </div>

                    <div class="input-group mb-3">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">ACCEDER</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection