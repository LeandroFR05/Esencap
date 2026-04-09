document.getElementById("cliente").addEventListener("input", filterTable);
document.getElementById("fecha").addEventListener("change", filterTable);

function filterTable() {
    // 1. Obtener los valores de ambos filtros
    const filtroCliente = document.getElementById("cliente").value.trim().toLowerCase();
    const filtroFecha = document.getElementById("fecha").value; // Formato YYYY-MM-DD
    
    const rows = document.querySelectorAll("#tableHistorial tbody tr");
    let visibleRows = 0;

    rows.forEach(row => {
        const cells = row.getElementsByTagName("td");
        
        // 2. Extraer los datos de las celdas (Fecha es índice 0, Producto es índice 1)
        const textoFecha = cells[0].textContent.trim();
        const textoProducto = cells[1].textContent.trim().toLowerCase();
        
        // Convertir filtroFecha (YYYY-MM-DD) a d-m-Y
        let filtroFechaDMY = "";
        if (filtroFecha) {
            const partes = filtroFecha.split("-"); // [YYYY, MM, DD]
            filtroFechaDMY = `${partes[2]}-${partes[1]}-${partes[0]}`;
        }

        // 3. Lógica de validación (Criterio Cruzado)
        // La fila se muestra solo si cumple AMBAS condiciones
        const coincideCliente = textoProducto.includes(filtroCliente);
        const coincideFecha = (filtroFechaDMY === "" || textoFecha === filtroFechaDMY);

        if (coincideCliente && coincideFecha) {
            row.style.display = "";
            visibleRows++;
        } else {
            row.style.display = "none";
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
            noResultsMsg.style.marginTop = "20px";
            noResultsMsg.style.fontSize = "18px";
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

function limpiarFiltros() {
    // 1. Buscamos los inputs por su ID y los vaciamos
    document.getElementById("cliente").value = "";
    document.getElementById("fecha").value = "";

    // 2. Ejecutamos la función de filtrado para que, 
    // al estar vacíos los inputs, se muestren todas las filas de nuevo.
    filterTable();
}

