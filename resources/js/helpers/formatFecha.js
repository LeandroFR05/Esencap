export function formatFecha(fecha) {
    const date = new Date(fecha);
    if (Number.isNaN(date.getTime())) {
        return fecha;
    }

    const dd = String(date.getDate()).padStart(2, '0');
    const mm = String(date.getMonth() + 1).padStart(2, '0');
    const yyyy = date.getFullYear();

    return `${dd}-${mm}-${yyyy}`;
}
