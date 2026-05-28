document.getElementById('ordenarFecha').addEventListener('change', function() {
    document.getElementById('formFiltros').submit();
});

function limpiarFiltros() {
    document.getElementById('ordenarFecha').value = '';
    document.getElementById('formFiltros').submit();
}
