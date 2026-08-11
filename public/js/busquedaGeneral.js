document.getElementById("producto").addEventListener("keypress", function(event) {
    // Permitir enviar con Enter
    if (event.key === "Enter") {
        document.getElementById("formFiltros").submit();
    }
});

document.getElementById("insumo").addEventListener("keypress", function(event) {
    // Permitir enviar con Enter
    if (event.key === "Enter") {
        document.getElementById("formFiltros").submit();
    }
});

document.getElementById("fecha").addEventListener("change", function() {
    // Enviar automáticamente al seleccionar una fecha
    document.getElementById("formFiltros").submit();
});

function limpiarFiltros() {
    // 1. Limpiar los inputs
    document.getElementById("nombre").value = "";
    document.getElementById("fecha").value = "";

    // 2. Enviar el formulario vacío (para resetear a todos los registros)
    document.getElementById("formFiltros").submit();
}



