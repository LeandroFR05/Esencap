const inputNombre = document.getElementById("nombre");
if (inputNombre) {
    inputNombre.addEventListener("keypress", function(event) {
        // Permitir enviar con Enter
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("formFiltros").submit();
        }
    });
}

window.limpiarFiltrosProductos = function() {
    // 1. Limpiar los inputs
    document.getElementById("nombre").value = "";
    document.getElementById("fecha").value = "";

    // 2. Enviar el formulario vacío (para resetear a todos los registros)
    document.getElementById("formFiltros").submit();
};