document.getElementById('btn-agregar').addEventListener('click', function() {

    let original = document.querySelector('.formula-item');
    let clone = original.cloneNode(true);

    // Limpiar valores y errores de validacion de la nueva fila
    clone.querySelectorAll('input').forEach(input => {
        input.value = '';
        input.classList.remove('is-invalid');
        input.removeAttribute('aria-invalid');
    });

    clone.querySelectorAll('.invalid-feedback, .valid-feedback').forEach(feedback => {
        feedback.remove();
    });

    // Resetear selects
    clone.querySelectorAll('select').forEach(select => {
        select.classList.remove('is-invalid');
        select.removeAttribute('aria-invalid');

        if (select.classList.contains('select-insumo')) {
            select.innerHTML = '<option value=""></option>';
        } else {
            select.selectedIndex = 0;
        }
    });

    // Se muestra el nuevo elemento (clon)
    document.getElementById('contenedor-formulas').appendChild(clone);
});