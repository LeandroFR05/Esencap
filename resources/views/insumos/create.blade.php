<!-- PLANTILLA -->
@extends('layouts.admin')

@section('page', 'Nuevo Insumo')

@section('title')
    {{ Breadcrumbs::render('nuevoInsumo') }}
@endsection

@section('styles')
    @vite('resources/css/Productos/estCreate.css')
@endsection

<!-- CONTENIDO -->
@section('content')
    <form id="form-insumo" method="POST" action="{{ route('insumos.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row g-3 justify-content-center">
            @component('components.cards-formCreate')
                @slot('titulo')
                    <small><i class="bi bi-plus-circle me-2"></i></small>Nuevo Insumo
                @endslot
                @slot('contenido')
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
                    <x-input-group name="stockInicial" label="Stock inicial" icon="bi-boxes" value="{{ old('stockInicial') }}" type="number" step="0.01" required>
                        <x-slot:select>
                            <select name="unidadDeMedida" id="unidadDeMedida" class="form-select">
                                <option value="gramos">gramos</option>
                                <option value="unidades">unidades</option>
                                <option value="kilos">kilos</option>
                                <option value="litros">litros</option>
                            </select>
                        </x-slot:select>
                    </x-input-group>

                    <div class="row g-3 justify-content-center">
                        <!-- Familia -->
                        <div class="col-md-6">
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
                        </div>

                        <!-- Fase -->
                        <div class="col-md-6"> 
                            <x-input-group name="fase" label="Fase" icon="bi-layers">
                                <x-slot:select>
                                    <select name="fase" id="fase" class="form-select" required>
                                        <option value="Acuosa">Acuosa</option>
                                        <option value="Oleosa">Oleosa</option>
                                        <option value="Activos">Activos</option>
                                    </select>
                                </x-slot:select>
                            </x-input-group>
                        </div>
                    </div>

                    <div class="row g-3 justify-content-center">
                        <!-- Fecha compra -->
                        <div class="col-md-6"> 
                            <x-input-group 
                                name="fechaCompra" 
                                label="Fecha de compra" 
                                type="date" 
                                icon="bi-calendar-plus" 
                                value="{{ old('fechaCompra') }}" 
                                required
                            />
                        </div>

                        <!-- Fecha vencimiento -->
                        <div class="col-md-6"> 
                            <x-input-group name="fechaVencimiento" 
                                label="Fecha de vencimiento" 
                                type="date" 
                                icon="bi-calendar-x" 
                                value="{{ old('fechaVencimiento') }}" 
                                required
                            />
                        </div>
                    </div>
                @endslot
            @endcomponent

            @component('components.cards-foto')
                @slot('titulo')
                    <small><i class="bi bi-image me-2"></small></i>Foto
                @endslot
                @slot('contenido')
                    @include('_partials.dropzone')
                @endslot
            @endcomponent
        </div>                       
    </form><br>

    @component('components.cards')
        @slot('contenido')
            <button type="submit" id="btn-submit" form="form-insumo" class="btn w-100">
                <i class="bi bi-check-circle me-1"></i> Guardar en el estante
            </button>
        @endslot
    @endcomponent

    @include('_modals.insumos.modalFamilia')
@endsection

@section('scripts')
    <script src="{{ asset('js/dropzone.js') }}"></script>
@endsection
