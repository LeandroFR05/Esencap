@extends('layouts.admin')

@section('page', 'Perfil')
@section('title', 'Perfil de Usuario')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Datos del Usuario</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre de Usuario</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" value="********" readonly disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="created_at">Fecha de Creación</label>
                                <input type="text" class="form-control" id="created_at" value="{{ $user->created_at->format('d/m/Y') }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="updated_at">Última Modificación</label>
                                <input type="text" class="form-control" id="updated_at" value="{{ $user->updated_at ? $user->updated_at->format('d/m/Y') : 'Nunca' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <h5>Cambiar Contraseña</h5>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="current_password">Contraseña Actual</label>
                                <input type="password" class="form-control" id="current_password" name="current_password">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="new_password">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="new_password_confirmation">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                </form>
            </div>
        </div>
    </div>
</div>

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
@endsection