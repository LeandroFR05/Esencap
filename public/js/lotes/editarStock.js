document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-stock-btn');
    const modal = document.getElementById('modalEditarStock');
    
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const loteId = this.dataset.id;
            const stockActual = this.dataset.stock;
            
            document.getElementById('loteId').value = loteId;
            document.getElementById('nuevoStock').value = stockActual;
            
            const action = `/lotes/actualizar/${loteId}`;
            document.getElementById('formEditarStock').action = action;
            
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        });
    });
});