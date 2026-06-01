// Filtro de búsqueda en tiempo real genérico para productos e insumos
document.addEventListener('DOMContentLoaded', function () {
    // Configuración de búsquedas disponibles
    const searchConfigs = [
        {
            inputId: 'buscarProducto',
            gridSelector: '.row.row-cols-2'
        },
        {
            inputId: 'buscarInsumo',
            gridSelector: '.row.row-cols-2'
        }
    ];

    searchConfigs.forEach(config => {
        const inputBusqueda = document.getElementById(config.inputId);
        if (!inputBusqueda) return;

        const grid = document.querySelector(config.gridSelector);
        if (!grid) return;

        const tarjetas = grid.querySelectorAll('.col');
        const mensajeVacio = grid.nextElementSibling;

        inputBusqueda.addEventListener('input', function () {
            const termino = this.value.toLowerCase().trim();
            let itemsVisibles = 0;

            tarjetas.forEach(col => {
                // Obtener el nombre del item desde el h5
                const nombre = col.querySelector('h5');
                if (!nombre) return;

                const nombreTexto = nombre.textContent.toLowerCase();

                if (nombreTexto.includes(termino)) {
                    col.style.display = '';
                    itemsVisibles++;
                } else {
                    col.style.display = 'none';
                }
            });

            // Mostrar mensaje de vacío si no hay resultados
            if (mensajeVacio && mensajeVacio.classList.contains('alert')) {
                mensajeVacio.style.display = itemsVisibles === 0 && termino.length > 0 ? 'flex' : 'none';
            }
        });
    });
});
