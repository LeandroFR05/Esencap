document.addEventListener('input', function(e) {

    if (e.target.classList.contains('porcentaje') || e.target.classList.contains('stockInicial') || e.target.classList.contains('contenidoPorUnidad')) {

        let contenidoPorUnidad = parseFloat(document.querySelector('.contenidoPorUnidad').value) || 0;
        let stockInicial = parseFloat(document.querySelector('.stockInicial').value) || 0;

        // Si cambia porcentaje recalcula solo ese bloque
        if (e.target.classList.contains('porcentaje')) {

            let bloque = e.target.closest('.formula-item');
            let inputContenido = bloque.querySelector('.contenido');

            let porcentaje = parseFloat(e.target.value) || 0;

            let resultado = ((porcentaje * contenidoPorUnidad) / 100) * stockInicial;

            inputContenido.value = resultado;
        }

        // Si cambia stockInicial o contenidoPorUnidad recalcula TODOS
        if (e.target.classList.contains('stockInicial') || e.target.classList.contains('contenidoPorUnidad')) {

            document.querySelectorAll('.formula-item')
                .forEach(bloque => {

                    let porcentaje = parseFloat(bloque.querySelector('.porcentaje').value) || 0;

                    let inputContenido = bloque.querySelector('.contenido');

                    let resultado = ((porcentaje * contenidoPorUnidad) / 100) * stockInicial;

                    inputContenido.value = resultado;
                });
        }
    }
});
