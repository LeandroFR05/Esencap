@extends('layouts.admin')
@section('page', 'Nuevo Insumo')
@section('title')
    {{ Breadcrumbs::render('nuevoInsumo') }}
@endsection

@section('content')
    @component('components.cards')
        @slot('titulo')
            <i class="bi bi-plus-circle me-2"></i>Nuevo Insumo
        @endslot

        @slot('contenido')
            <form id="form-insumo" method="POST" action="{{ route('insumos.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <!-- Columna izquierda -->
                    <div class="col-md-6">

                        <!-- Nombre -->
                        <x-input-group 
                            name="nombre"
                            label="Nombre"
                            type="text"
                            icon="bi-tag"
                            value="{{ old('nombre') }}"
                            required
                        />
                         
                        <!-- Stock inicial -->
                        <x-input-group name="stockInicial" label="Stock inicial" icon="bi-boxes" value="{{ old('stockInicial') }}" type="number">
                            <x-slot:select>
                                <select name="unidadDeMedida" id="unidadDeMedida" class="form-select">
                                    <option value="gramos">gramos</option>
                                    <option value="unidades">unidades</option>
                                    <option value="kilos">kilos</option>
                                    <option value="litros">litros</option>
                                </select>
                            </x-slot:select>
                        </x-input-group>

                        <!-- Familia -->
                        <x-input-group name="idFamilia" label="Familia" icon="bi-diagram-3">
                            <x-slot:select>
                                <select name="idFamilia" id="idFamilia" class="form-select" required>
                                    @foreach($familias as $familia)
                                        <option value="{{ $familia->idFamilia }}">
                                            {{ $familia->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </x-slot:select>
                            <x-slot:button>
                                <button type="button" class="btn btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#modalFamilia">
                                    <i class="bi bi-plus-lg"></i>
                                </button>
                            </x-slot:button>
                        </x-input-group>

                        <!-- Fase -->
                        <x-input-group name="fase" label="Fase" icon="bi-layers">
                            <x-slot:select>
                                <select name="fase" id="fase" class="form-select" required>
                                    <option value="primera">Acuosa</option>
                                    <option value="segunda">Oleosa</option>
                                    <option value="tercera">Activos</option>
                                </select>
                            </x-slot:select>
                        </x-input-group>

                        <!-- Fecha compra -->
                        <x-input-group 
                            name="fechaCompra" 
                            label="Fecha de compra" 
                            type="date" 
                            icon="bi-calendar-plus" 
                            value="{{ old('fechaCompra') }}" 
                            required
                        />
                    </div>

                    <!-- Columna derecha -->
                    <div class="col-md-6">
                        <!-- Foto -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Foto</label>
                            @include('_partials.dropzone')
                        </div>

                        <!-- Fecha vencimiento -->
                        <x-input-group name="fechaVencimiento" 
                            label="Fecha de vencimiento" 
                            type="date" 
                            icon="bi-calendar-x" 
                            value="{{ old('fechaVencimiento') }}" 
                            required
                        />
                    </div>
                </div>
            </form>
        @endslot

        @slot('footer')
            <div class="row g-4">
                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" form="form-insumo" class="btn btn-success">
                        <i class="bi bi-floppy me-1"></i> Guardar
                    </button>
                </div>
            </div>
        @endslot
    @endcomponent

    @include('_modals.insumos.modalFamilia')
@endsection

@section('scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>
@endsection
