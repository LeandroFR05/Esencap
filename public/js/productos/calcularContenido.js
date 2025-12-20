document.addEventListener('change', function(e) {
    if (e.target.classList.contains('porcentaje')) {
        
        // Obtenemos los valores
        let inputPorcentaje = e.target;
        let porcentaje = parseFloat(inputPorcentaje.value) || 0;
        let contenidoPorUnidad = parseFloat(document.querySelector('.contenidoPorUnidad').value) || 0;

        // Para encontrar el clon o bloque correcto
        let bloque = inputPorcentaje.closest('.formula-item');
        let inputContenido = bloque.querySelector('.contenido');

        // Hacemos la operación
        let resultado = (porcentaje * contenidoPorUnidad) / 100;
        inputContenido.value = resultado;

    }
});