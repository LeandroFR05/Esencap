document.addEventListener('change', function(e) {
    if (e.target.classList.contains('select-familia')) {

        let selectFamilia = e.target;
        let idFamilia = selectFamilia.value;

        // Buscar el select de insumos del mismo bloque (misma fila)
        let bloque = selectFamilia.closest('.formula-item');
        let selectInsumo = bloque.querySelector('.select-insumo');

        fetch('/insumos/' + idFamilia)
            .then(response => response.json())
            .then(data => {
                selectInsumo.innerHTML = "";

                data.forEach(insumo => {
                    let option = document.createElement('option');
                    option.value = insumo.idInsumo;
                    option.textContent = insumo.nombre;
                    selectInsumo.appendChild(option);
                });
            })
            .catch(error => console.error(error));
    }
});