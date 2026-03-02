@extends('layouts.admin')
@section('page', 'Nuevo Insumo')
@section('title')
    {{ Breadcrumbs::render('nuevoInsumo') }}
@endsection

@section('content')
    @component('components.cards')
        @slot('titulo', 'Nuevo Insumo')
        @slot('contenido')
            <form method="POST" action="{{ route('insumos.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" required>
                        <div class="mt-3">
                            <label for="stockInicial">Stock Inicial</label>
                            <div class="input-group">
                                <input type="number" name="stockInicial" class="form-control">
                                <select name="unidadDeMedida" class="form-select">
                                    <option value="gramos">gramos</option>
                                    <option value="unidades">unidades</option>
                                    <option value="kilos">kilos</option>
                                    <option value="litros">litros</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="idFamilia">Familia:</label>
                            <div class="d-flex align-items-center">
                                <select name="idFamilia" class="form-control" required>
                                    @foreach($familias as $familia)
                                        <option value="{{ $familia->idFamilia }}">{{ $familia->nombre }}</option>
                                    @endforeach
                                </select>
                                <!--Usamos una botón que nos lleva a una ventana modal para poder crear familias-->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFamilia">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-3">
                            <label for="fase">Fase:</label>
                            <input type="text" name="fase" class="form-control" required>
                        </div>
                        <div class="mt-3">
                            <label for="fechaCompra">Fecha de Compra:</label>
                            <input type="date" name="fechaCompra" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label for="foto">Foto:</label>
                        @include('_partials.dropzone')
                        <div class="mt-3">
                            <label for="fechaVencimiento">Fecha de Vencimiento:</label>
                            <input type="date" name="fechaVencimiento" class="form-control" required>
                        </div>
                    </div>
                </div>
                <br>
        @endslot
        
        @slot('footer')
            <div class="row g-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success w-100">Agregar</button>
                </div>
            </div>
            </form>
        @endslot
        
    @endcomponent

    @include('_modals.modalFamilia')

@endsection

@section('scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>
@endsection