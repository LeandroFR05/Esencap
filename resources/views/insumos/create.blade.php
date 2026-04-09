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
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="form-control @error('nombre') is-invalid @enderror" required>
                        
                        <div class="mt-3">
                            <label for="stockInicial">Stock Inicial</label>
                            <div class="input-group">
                                <input type="number" name="stockInicial" id="stockInicial" value="{{ old('stockInicial') }}" class="form-control @error('stockInicial') is-invalid @enderror">
                                <select name="unidadDeMedida" id="unidadDeMedida" class="form-select">
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
                                <select name="idFamilia" id="idFamilia" value="{{ old('idFamilia') }}" class="form-control" required>
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
                            <select name="fase" id="fase" value="{{ old('fase') }}" class="form-control" required>
                                <option value="primera">Acuosa</option>
                                <option value="segunda">Oleosa</option>
                                <option value="tercera">Activos</option>
                            </select>
                        </div>

                        <div class="mt-3">
                            <label for="fechaCompra">Fecha de Compra:</label>
                            <input type="date" name="fechaCompra" id="fechaCompra" value="{{ old('fechaCompra') }}" class="form-control @error('fechaCompra') is-invalid @enderror" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <label>Foto:</label>
                        @include('_partials.dropzone')
                        
                        <div class="mt-3">
                            <label for="fechaVencimiento">Fecha de Vencimiento:</label>
                            <input type="date" name="fechaVencimiento" id="fechaVencimiento" value="{{ old('fechaVencimiento') }}" class="form-control @error('fechaVencimiento') is-invalid @enderror" required>
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

