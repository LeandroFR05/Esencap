document.getElementById('btn-agregar').addEventListener('click', function() {

    let original = document.querySelector('.formula-item');
    let clone = original.cloneNode(true);

    // Limpiar inputs
    clone.querySelectorAll('input').forEach(input => input.value = '');

    // Resetear selects
    clone.querySelectorAll('select').forEach(select => {

        if (select.classList.contains('select-insumo')) {
            select.innerHTML = '<option value=""></option>';
        } else {
            select.selectedIndex = 0;
        }
    });

    document.getElementById('contenedor-formulas').appendChild(clone);
});