// Seleccionamos el botón y le añadimos un evento click
document.getElementById('btn-agregar').addEventListener('click', function() {

    // Seleccionamos el primer bloque
    let original = document.querySelector('.formula-item');

    // Lo clonamos
    let clone = original.cloneNode(true);

    // Limpiar los inputs
    clone.querySelectorAll('input').forEach(input => input.value = '');

    // Resetear selects
    clone.querySelectorAll('select').forEach(select => {
        select.selectedIndex = 0;
    });

    // Agregar el clon al contenedor
    document.getElementById('contenedor-formulas').appendChild(clone);
});