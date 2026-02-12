document.addEventListener('DOMContentLoaded', function () {
    const dropzoneLabel = document.getElementById('dropzone-label');
    const fileInput = document.getElementById('dropzone-file');
    const dropzoneContent = document.getElementById('dropzone-content');
    const dropzonePreview = document.getElementById('dropzone-preview');
    const previewImage = document.getElementById('preview-image');
    const removeBtn = document.getElementById('remove-btn');

    // Funciones visuales
    const showPreview = (file) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.src = e.target.result;
            dropzoneContent.classList.add('d-none');
            dropzonePreview.classList.remove('d-none');
            dropzonePreview.classList.add('d-flex');
        };
        reader.readAsDataURL(file);
    };

    const resetDropzone = (e) => {
        if(e) e.stopPropagation(); // Evitar que el click llegue al input
        fileInput.value = ''; // Limpiar input
        previewImage.src = '';
        dropzoneContent.classList.remove('d-none');
        dropzonePreview.classList.add('d-none');
        dropzonePreview.classList.remove('d-flex');
        dropzoneLabel.classList.remove('border-primary', 'bg-light'); // Quitar estilos de "activo"
    };

    // 1. Manejar selección por Click
    fileInput.addEventListener('change', (e) => {
        if (e.target.files.length > 0) {
            showPreview(e.target.files[0]);
        }
    });

    // 2. Manejar Drag & Drop
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropzoneLabel.addEventListener(eventName, (e) => {
            e.preventDefault();
            e.stopPropagation();
        }, false);
    });

    // Efecto visual al arrastrar encima (hover effect)
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzoneLabel.addEventListener(eventName, () => {
            dropzoneLabel.classList.add('border-primary', 'bg-white'); // Feedback visual
            dropzoneLabel.classList.remove('border-secondary', 'bg-light');
        });
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropzoneLabel.addEventListener(eventName, () => {
            dropzoneLabel.classList.remove('border-primary', 'bg-white');
            dropzoneLabel.classList.add('border-secondary', 'bg-light');
        });
    });

    // Al soltar el archivo
    dropzoneLabel.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            fileInput.files = files; // Asignar archivos al input real
            showPreview(files[0]);
        }
    });

    // 3. Botón de eliminar
    removeBtn.addEventListener('click', resetDropzone);
});