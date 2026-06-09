// El formulario se envía automáticamente al hacer Enter o al cambiar la fecha
// Los filtros se envían vía URL: ?cliente=X&fecha=Y

document.getElementById("cliente").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        document.getElementById("formFiltros").submit();
    }
});

document.getElementById("fecha").addEventListener("change", function() {
    document.getElementById("formFiltros").submit();
});

function limpiarFiltros() {
    document.getElementById("cliente").value = "";
    document.getElementById("fecha").value = "";
    document.getElementById("formFiltros").submit();
}
