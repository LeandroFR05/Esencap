document.getElementById('btn-borrar').addEventListener('click', function() {

    let contenedor = document.getElementById('contenedor-formulas');
    let bloques = contenedor.querySelectorAll('.formula-item');

    // Evitar eliminar el primer bloque
    if (bloques.length > 1) {
        let ultimo = bloques[bloques.length - 1];
        ultimo.remove();
    } else {
        alert("No se puede borrar todos los bloques");
    }
});