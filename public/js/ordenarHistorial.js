document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('#tableHistorial .sortable').forEach(th => {
        th.style.cursor = 'pointer';

        th.addEventListener('click', () => {
            const table = document.getElementById('tableHistorial');
            const tbody = table.querySelector('tbody');
            const col   = parseInt(th.dataset.col);
            const dir   = th.dataset.dir;
            const rows  = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                const aText = a.cells[col].innerText.trim();
                const bText = b.cells[col].innerText.trim();

                const aNum = parseFloat(aText);
                const bNum = parseFloat(bText);
                const isNum = !isNaN(aNum) && !isNaN(bNum);

                const dateRegex = /^\d{2}-\d{2}-\d{4}$/;
                const isDate = dateRegex.test(aText) && dateRegex.test(bText);

                if (isDate) {
                    const aDate = aText.split('-').reverse().join('-');
                    const bDate = bText.split('-').reverse().join('-');

                    return dir === 'asc'
                        ? aDate.localeCompare(bDate)
                        : bDate.localeCompare(aDate);

                } else if (isNum) {

                    return dir === 'asc'
                        ? aNum - bNum
                        : bNum - aNum;

                } else {

                    return dir === 'asc'
                        ? aText.localeCompare(bText)
                        : bText.localeCompare(aText);
                }
            });

            rows.forEach(row => tbody.appendChild(row));

            document.querySelectorAll('#tableHistorial .sortable i').forEach(icon => {
                icon.className = 'bi bi-arrow-down-up text-secondary ms-1';
            });

            const icon = th.querySelector('i');

            if (dir === 'asc') {
                icon.className = 'bi bi-arrow-up text-white ms-1';
                th.dataset.dir = 'desc';

            } else {
                icon.className = 'bi bi-arrow-down text-white ms-1';
                th.dataset.dir = 'asc';
            }
        });
    });

});