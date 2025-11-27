document.getElementById('idFamilia').addEventListener('change', function() {
    let idFamilia = this.value;

    fetch('/insumos/' + idFamilia)
        .then(response => response.json())
        .then(data => {
            let insumoSelect = document.getElementById('idInsumo');
            insumoSelect.innerHTML = ""; // limpiar

            data.forEach(insumo => {
                let option = document.createElement('option');
                option.value = insumo.idInsumo;
                option.textContent = insumo.nombre;
                insumoSelect.appendChild(option);
            });
        })
        .catch(error => console.error(error));
});