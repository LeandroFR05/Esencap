(() => {
    const stockInicial = document.getElementById('stockInicial');
    const contenidoPorUnidad = document.getElementById('contenidoPorUnidad');
    const volumenTotal = document.getElementById('volumenTotal');

    if (!stockInicial || !contenidoPorUnidad || !volumenTotal) {
        return;
    }

    const actualizarVolumenTotal = () => {
        const stock = Number(stockInicial.value);
        const contenido = Number(contenidoPorUnidad.value);
        const total = stock > 0 && contenido > 0 ? stock * contenido : 0;

        volumenTotal.textContent = total.toLocaleString('es-AR', {
            maximumFractionDigits: 2,
        });
    };

    stockInicial.addEventListener('input', actualizarVolumenTotal);
    contenidoPorUnidad.addEventListener('input', actualizarVolumenTotal);
    actualizarVolumenTotal();
})();