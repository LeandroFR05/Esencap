document.addEventListener('change', function(e) {
    if (e.target.classList.contains('select-familia')) {

        let selectFamilia = e.target;
        let idFamilia = selectFamilia.value;

        // Buscar el select de insumos del mismo bloque (misma fila)
        let bloque = selectFamilia.closest('.formula-item');
        let selectInsumo = bloque.querySelector('.select-insumo');

        // Realizo la consulta para traer los insumos de esa familia
        fetch('/insumos/' + idFamilia)
            .then(response => response.json())
            .then(data => {
                selectInsumo.innerHTML = "";

                // Agrego options, que contienen los insumos correspondientes a esa familia que traje de la consulta
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