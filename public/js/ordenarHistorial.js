document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('tableHistorial');
    if (!table) return;

    const tbody = table.querySelector('tbody');
    const headers = table.querySelectorAll('.sortable');

    headers.forEach(th => {
        th.style.cursor = 'pointer';

        th.addEventListener('click', () => {
            const col = th.dataset.col;
            
            // 1. Alternamos la dirección (ascendente/descendente)
            const dir = th.dataset.dir === 'asc' ? 'desc' : 'asc';
            th.dataset.dir = dir;

            const rows = Array.from(tbody.querySelectorAll('tr'));

            // 2. Ordenamos las filas
            rows.sort((a, b) => {
                let valA = a.cells[col].innerText.trim();
                let valB = b.cells[col].innerText.trim();

                // Convertimos formato fecha (DD-MM-YYYY -> YYYY-MM-DD) para que se ordene bien
                const dateRegex = /^(\d{2})-(\d{2})-(\d{4})/;
                valA = valA.replace(dateRegex, '$3-$2-$1');
                valB = valB.replace(dateRegex, '$3-$2-$1');

                // localeCompare con 'numeric:true' resuelve automáticamente textos y números
                const result = valA.localeCompare(valB, undefined, { numeric: true });
                return dir === 'asc' ? result : -result;
            });

            // 3. Reinsertamos las filas ya ordenadas
            tbody.append(...rows);

            // 4. Actualizamos los íconos visuales
            headers.forEach(h => {
                const icon = h.querySelector('i');
                if (icon) icon.className = 'bi bi-arrow-down-up text-white ms-1';
            });
            
            const activeIcon = th.querySelector('i');
            if (activeIcon) {
                activeIcon.className = `bi bi-arrow-${dir === 'asc' ? 'up' : 'down'} text-white ms-1`;
            }
        });
    });
});