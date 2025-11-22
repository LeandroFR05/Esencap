document.getElementById('insumos').addEventListener('change', function() {
    let insumoSeleccionado = this.value;

    // Todos los items del acordeón
    let items = document.querySelectorAll('.accordion-item');

    items.forEach(item => {
        // Obtenemos su ID real del accordion
        let itemID = item.querySelector('.accordion-collapse').id.replace('collapse-', '');

        if (insumoSeleccionado === 'todos') {
            item.style.display = 'block'; // mostrar todos
        } else
            if (itemID === insumoSeleccionado) {
                item.style.display = 'block'; // mostrar
            } else {
                item.style.display = 'none'; // ocultar
            }
    });
});