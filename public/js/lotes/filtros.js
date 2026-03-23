document.getElementById('insumos').addEventListener('change', function() {
    const insumo = this.value;
    const cards = document.querySelectorAll('#cardLotes');

    cards.forEach(card => {
        // Buscamos el nombre del insumo en el <h6> dentro del card
        const insumoNombre = card.querySelector('h6').textContent.trim();

        if (insumo === 'todos') {
            card.style.display = '';
        } else {
            card.style.display = insumoNombre === insumo ? '' : 'none';
        }
    });
});