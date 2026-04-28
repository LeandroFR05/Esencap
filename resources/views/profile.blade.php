@extends('layouts.admin')

@section('page', 'Perfil')
@section('title', 'Perfil de Usuario')

@section('content')
    @component('components.cards')
        @slot('titulo')
            <i class="bi bi-person-circle me-2"></i>Datos del usuario
        @endslot

        @slot('contenido')
            <form id="form-perfil" action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Información de la cuenta --}}
                <p class="text-muted small text-uppercase fw-semibold mb-3">
                    <i class="bi bi-info-circle me-1"></i>Información de la cuenta
                </p>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label fw-semibold">Nombre de usuario</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="name" name="name"
                                   value="{{ $user->name }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="email" class="form-label fw-semibold">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ $user->email }}" required>
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="password" class="form-label fw-semibold">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password"
                                   value="********" readonly disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="created_at" class="form-label fw-semibold">Fecha de creación</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-plus"></i></span>
                            <input type="text" class="form-control" id="created_at"
                                   value="{{ $user->created_at->format('d/m/Y') }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="updated_at" class="form-label fw-semibold">Última modificación</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar-check"></i></span>
                            <input type="text" class="form-control" id="updated_at"
                                   value="{{ $user->updated_at ? $user->updated_at->format('d/m/Y') : 'Nunca' }}"
                                   readonly>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Cambiar contraseña --}}
                <p class="text-muted small text-uppercase fw-semibold mb-3">
                    <i class="bi bi-shield-lock me-1"></i>Cambiar contraseña
                </p>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="current_password" class="form-label fw-semibold">Contraseña actual</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control"
                                   id="current_password" name="current_password">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="new_password" class="form-label fw-semibold">Nueva contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key"></i></span>
                            <input type="password" class="form-control"
                                   id="new_password" name="new_password">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="new_password_confirmation" class="form-label fw-semibold">Confirmar contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                            <input type="password" class="form-control"
                                   id="new_password_confirmation" name="new_password_confirmation">
                        </div>
                    </div>
                </div>

            </form>
        @endslot

        @slot('footer')
            <div class="d-flex justify-content-end">
                <button type="submit" form="form-perfil" class="btn btn-success">
                    <i class="bi bi-floppy me-1"></i> Guardar cambios
                </button>
            </div>
        @endslot
    @endcomponent
@endsection

@if(session('success'))
    <script>
        Swal.fire('Éxito', '{{ session("success") }}', 'success');
    </script>
@endif

@if($errors->any())
    <script>
        Swal.fire('Error', '{{ $errors->first() }}', 'error');
    </script>
@endif