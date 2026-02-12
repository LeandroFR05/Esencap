document.getElementById('dropzone-file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('dropzone-preview').classList.remove('d-none');
            document.getElementById('dropzone-content').classList.add('d-none');
        }
        reader.readAsDataURL(file);
    }
});

document.getElementById('remove-btn').addEventListener('click', function(e) {
    e.preventDefault();
    e.stopPropagation(); // Evita que se abra el selector de archivos al hacer clic en X
    
    document.getElementById('dropzone-file').value = ""; // Limpia el input
    document.getElementById('preview-image').src = "";
    document.getElementById('dropzone-preview').classList.add('d-none');
    document.getElementById('dropzone-content').classList.remove('d-none');
});