// Delegación: cualquier botón .btn-eliminar elimina su bloque
// (incluidos los clónicos creados dinamicamente)
document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-eliminar');
    if (!btn) return;

    const item = btn.closest('.formula-item');

    if(document.querySelectorAll('.formula-item').length > 1){
        item.remove();
    }
    else{
        Swal.fire({
            title: 'Error',
            text: "No se puede eliminar toda la fórmula",
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    }
});