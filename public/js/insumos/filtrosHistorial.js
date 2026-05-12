// Escuchar cambios en tiempo real
document.getElementById('insumo').addEventListener('input', filtrarTabla);
document.getElementById('fechaCompra').addEventListener('change', filtrarTabla);
document.getElementById('fechaVencimiento').addEventListener('change', filtrarTabla);

function filtrarTabla() {
    //Valores de los filtros
    const insumo = document.getElementById('insumo').value.toLowerCase().trim();
    const fechaCompra = document.getElementById('fechaCompra').value;
    const fechaVencimiento = document.getElementById('fechaVencimiento').value;

    const filas = document.querySelectorAll('#tableHistorial tbody tr');

    filas.forEach(fila => {
        const celdas = fila.querySelectorAll('td');
        
        //Valores de la tabla
        const nombreInsumo = celdas[2].textContent.toLowerCase().trim();
        const compra = celdas[1].textContent.trim();
        const vencimiento = celdas[5].textContent.trim();

        const coincideInsumo = insumo === '' || nombreInsumo.includes(insumo);
        const coincideCompra = fechaCompra === '' || formatearFecha(compra) === fechaCompra;
        const coincideVencimiento = fechaVencimiento === '' || formatearFecha(vencimiento) === fechaVencimiento;

        if (coincideInsumo && coincideCompra && coincideVencimiento) {
            fila.style.display = '';
            visibleRows++;
        } else {
            fila.style.display = 'none';
        }
    });

    // Mostrar mensaje si no hay resultados
    let noResultsMsg = document.getElementById("no-results");
    if (visibleRows === 0) {
        if (!noResultsMsg) {
            noResultsMsg = document.createElement("div");
            noResultsMsg.id = "no-results";
            noResultsMsg.textContent = "No hay resultados";
            noResultsMsg.style.textAlign = "center";
            noResultsMsg.style.fontSize = "15px";
            noResultsMsg.style.color = "#666";
            document.querySelector("#tableHistorial").parentNode.appendChild(noResultsMsg);
        } else {
            noResultsMsg.style.display = "";
        }
    } else {
        if (noResultsMsg) {
            noResultsMsg.style.display = "none";
        }
    }
}

function formatearFecha(fechaTexto) {
    if (!fechaTexto) return '';
    if (fechaTexto.includes('-')) {
        const [dia, mes, anio] = fechaTexto.split('-');
        const resultado = `${anio}-${mes.padStart(2, '0')}-${dia.padStart(2, '0')}`;
        console.log(`Entrada: ${fechaTexto} → Salida: ${resultado}`);
        return resultado;
    }
    console.log(`Formato inesperado: ${fechaTexto}`);
    return fechaTexto;
}

function limpiarFiltros() {
    document.getElementById('insumo').value = '';
    document.getElementById('fechaCompra').value = '';
    document.getElementById('fechaVencimiento').value = '';
    filtrarTabla();
}