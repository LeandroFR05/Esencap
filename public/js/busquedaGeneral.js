const productoInput = document.getElementById("producto");
if (productoInput) {
    productoInput.addEventListener("keypress", function(event) {
        // Permitir enviar con Enter
        if (event.key === "Enter") {
            const form = document.getElementById("formFiltros");
            if (form) {
                form.submit();
            }
        }
    });
}

const insumoInput = document.getElementById("insumo");
if (insumoInput) {
    insumoInput.addEventListener("keypress", function(event) {
        // Permitir enviar con Enter
        if (event.key === "Enter") {
            const form = document.getElementById("formFiltros");
            if (form) {
                form.submit();
            }
        }
    });
}

window.limpiarFiltrosProductos = function() {
    const nombre = document.getElementById("nombre");
    const fecha = document.getElementById("fecha");
    const form = document.getElementById("formFiltros");

    if (nombre) {
        nombre.value = "";
    }
    if (fecha) {
        fecha.value = "";
    }
    if (form) {
        form.submit();
    }
};

window.limpiarFiltrosInsumos = function() {
    const nombre = document.getElementById("nombre");
    const familia = document.getElementById("familia");
    const fecha = document.getElementById("fecha");
    const form = document.getElementById("formFiltros");

    if (nombre) {
        nombre.value = "";
    }
    if (familia) {
        familia.value = "";
    }
    if (fecha) {
        fecha.value = "";
    }
    if (form) {
        form.submit();
    }
};



