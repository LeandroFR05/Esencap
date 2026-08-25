// El formulario se envía automáticamente al hacer Enter o al cambiar un filtro
// Los filtros se envían vía URL: ?cliente=X&fecha=Y&orden=reciente

document.getElementById("cliente").addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        document.getElementById("formFiltros").submit();
    }
});

document.getElementById("fecha").addEventListener("change", function() {
    document.getElementById("formFiltros").submit();
});

document.getElementById("orden").addEventListener("change", function() {
    document.getElementById("formFiltros").submit();
});

function limpiarFiltros() {
    document.getElementById("cliente").value = "";
    document.getElementById("fecha").value = "";
    document.getElementById("orden").value = "";
    document.getElementById("formFiltros").submit();
}
