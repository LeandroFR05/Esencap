// El formulario se envía automáticamente al hacer click en "Buscar"
// Los filtros se envían vía URL: ?insumo=X&fechaCompra=Y&fechaVencimiento=Z

document.getElementById('insumo').addEventListener('keypress', function(event) {
    // Permitir enviar con Enter
    if (event.key === 'Enter') {
        document.getElementById('formFiltros').submit();
    }
});

document.getElementById('fechaCompra').addEventListener('change', function() {
    // Enviar automáticamente al seleccionar una fecha
    document.getElementById('formFiltros').submit();
});

document.getElementById('fechaVencimiento').addEventListener('change', function() {
    // Enviar automáticamente al seleccionar una fecha
    document.getElementById('formFiltros').submit();
});

document.getElementById('orden').addEventListener('change', function() {
    document.getElementById('formFiltros').submit();
});


// document.getElementById('estado').addEventListener('change', function() {
//     const estado = document.getElementById('estado').value;
//     const filas = document.querySelectorAll("#tableHistorial tbody tr");

//     filas.forEach(fila => {
//         const celda = fila.getElementsByTagName("td");
//         const estadoTabla = celda[6].textContent.trim();

//         const coincideEstado = (estado === "" || estadoTabla === estado);

//         if (coincideEstado) {
//             fila.style.display = "";
//         } else {
//             fila.style.display = "none";
//         }
//     });
// });


function limpiarFiltros() {
    // 1. Limpiar los inputs
    document.getElementById('insumo').value = '';
    document.getElementById('fechaCompra').value = '';
    document.getElementById('fechaVencimiento').value = '';
    document.getElementById('estado').value = '';
    document.getElementById('orden').value = '';
    // 2. Enviar el formulario vacío (para resetear a todos los registros)
    document.getElementById('formFiltros').submit();
}


