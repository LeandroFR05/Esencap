<!-- Modal Crear Familia -->
<div class="modal fade" id="modalFamilia" tabindex="-1" aria-labelledby="modalFamiliaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFamiliaLabel">Crear Nueva Familia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="formFamilia">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
document.getElementById('formFamilia').addEventListener('submit', function(e) {
    e.preventDefault();

    let formData = new FormData(this);

    fetch("{{ route('familias.store') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Agregamos la nueva familia al select
        let select = document.querySelector('select[name="idFamilia"]');
        let option = document.createElement('option');
        option.value = data.idFamilia;
        option.text = data.nombre;
        option.selected = true;
        select.appendChild(option);

        // Cerramos modal
        let modal = bootstrap.Modal.getInstance(document.getElementById('modalFamilia'));
        modal.hide();
    });
});
</script>
