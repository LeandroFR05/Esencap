document.getElementById('ordenarFecha').addEventListener('change', function() {
    document.getElementById('formFiltros').submit();
});

document.getElementById('limpiarFiltros').addEventListener('click', function() {
    document.getElementById('buscarProducto').value = '';
    window.location.href = this.dataset.clearUrl;
});
