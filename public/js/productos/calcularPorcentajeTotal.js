(() => {
    const sumaTotalPorcentaje = document.getElementById('sumaTotalPorcentaje');

    if (!sumaTotalPorcentaje) {
        return;
    }

    const actualizarSumaTotal = () => {
        const total = Array.from(document.querySelectorAll('.porcentaje'))
            .reduce((suma, input) => suma + (Number(input.value) || 0), 0);

        sumaTotalPorcentaje.textContent = total.toLocaleString('es-AR', {
            maximumFractionDigits: 2,
        });
    };

    document.addEventListener('input', (event) => {
        if (event.target.matches('.porcentaje')) {
            actualizarSumaTotal();
        }
    });

    document.addEventListener('click', (event) => {
        if (event.target.closest('.btn-eliminar')) {
            actualizarSumaTotal();
        }
    });

    actualizarSumaTotal();
})();