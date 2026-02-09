document.getElementById('insumos').addEventListener('change', function() {
    const insumo = this.value;
    // Seleccionamos el cuerpo de la tabla y sus filas
    const filas = document.querySelectorAll('#tableLotes tbody tr');

    filas.forEach(fila => {
        // Obtenemos su ID real de la tabla
        const cells = fila.getElementsByTagName('td');
        
        if (insumo === 'todos') {
            fila.style.display = '';
        } else {
            const insumoText = cells[0].textContent;
            fila.style.display = insumoText.includes(insumo) ? '' : 'none';
        }
    });
});