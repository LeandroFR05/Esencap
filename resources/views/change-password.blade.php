@extends('layouts.admin')

@section('page', 'Cambiar contraseña')
@section('title', 'Cambiar contraseña')

@section('content')
    @component('components.cards')
        @slot('titulo')
            <i class="bi bi-shield-lock me-2"></i>Cambiar contraseña
        @endslot

        @slot('contenido')
            <form id="form-cambiar-contraseña" action="{{ route('profile.password.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="current_password" class="form-label fw-semibold">Contraseña actual</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="new_password" class="form-label fw-semibold">Nueva contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="new_password_confirmation" class="form-label fw-semibold">Confirmar contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                            <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password_confirmation" name="new_password_confirmation" required>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </form>
        @endslot

        @slot('footer')
            <div class="d-flex justify-content-between">
                <a href="{{ route('profile') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Volver al perfil
                </a>
                <button type="submit" form="form-cambiar-contraseña" class="btn btn-success">
                    <i class="bi bi-floppy me-1"></i>Actualizar contraseña
                </button>
            </div>
        @endslot
    @endcomponent
@endsection

