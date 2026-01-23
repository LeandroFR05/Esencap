<div class="row">   
    <div class="col">
        <label for="formulaBase" class="form-label">Formula Base</label>
    </div>
    <div class="col">
        <label for="formulaRecalculada" class="form-label">Formula Recalculada</label>
    </div>
</div>

<div class="row">
    <div class="col">
        <label for="porcentaje" class="form-label">Porcentaje</label>
    </div>
    <div class="col">
        <label for="idFamilia" class="form-label">Familia</label>
    </div>
    <div class="col">
        <label for="contenido" class="form-label">Contenido</label>
    </div>
    <div class="col">
        <label for="idInsumo" class="form-label">Insumo</label>
    </div>
</div>

@foreach($formula as $fila)
    <div class="row formula-item">
        <div class="col">
            <input type="number" name="porcentaje[]" value="{{ $fila['porcentaje'] }}" class="form-control porcentaje" required>
        </div>
        <div class="col">
            <input type="text" name="familia[]" value="{{ $fila['familia'] }}" class="form-control" required>
        </div>
        <div class="col">
            <input type="number" name="contenido[]" value="{{ $fila['contenido'] }}" class="form-control" required>
        </div>
        <div class="col">
            <input type="text" name="insumo[]" value="{{ $fila['insumo'] }}" class="form-control" required>
        </div>
    </div>
@endforeach