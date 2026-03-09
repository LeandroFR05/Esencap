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

    // Botón eliminar
    let btnEliminar = clone.querySelector('.btn-eliminar');
    if (btnEliminar) {
        btnEliminar.addEventListener('click', function () {
            clone.remove();
        });
    }

    document.getElementById('contenedor-formulas').appendChild(clone);
});


// Evento eliminar para el primer bloque
document.addEventListener('click', function(e){
    if(e.target.classList.contains('btn-eliminar')){
        let item = e.target.closest('.formula-item');

        if(document.querySelectorAll('.formula-item').length > 1){
            item.remove();
        }
    }
});