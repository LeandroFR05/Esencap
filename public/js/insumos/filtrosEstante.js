document.getElementById('ordenarFecha').addEventListener('change', function() {
    document.getElementById('formFiltros').submit();
});

document.getElementById('familia').addEventListener('change', function() {
    document.getElementById('formFiltros').submit();
});

document.getElementById('limpiarFiltros').addEventListener('click', function() {
    document.getElementById('buscarInsumo').value = '';
    window.location.href = this.dataset.clearUrl;
});
