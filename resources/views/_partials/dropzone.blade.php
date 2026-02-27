<label for="dropzone-file" id="dropzone-label" class="d-flex flex-column align-items-center justify-content-center w-100 border border-2 border-dashed border-secondary rounded-3 bg-light position-relative overflow-hidden" style="height: 16.9rem; cursor: pointer;">
    <div id="dropzone-content" class="d-flex flex-column align-items-center justify-content-center pt-5 pb-6">
        <svg class="mb-4 text-secondary" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16" width="40" height="40">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
        </svg>
        <p class="mb-2 text-sm text-secondary"><span class="fw-bold">Haz clic para subir</span> o arrastra y suelta</p>
        <p class="text-xs text-secondary">SVG, PNG, JPG o GIF (MAX. 800x400px)</p>
    </div>

    <div id="dropzone-preview" class="{{ isset($foto) && $foto ? '' : 'd-none' }} w-100 h-100 position-absolute top-0 start-0 d-flex justify-content-center align-items-center bg-white">
        <img id="preview-image" src="{{ isset($foto) && $foto ? asset('storage/' . $foto) : '' }}" alt="Previsualización" style="max-height: 100%; max-width: 100%; object-fit: contain;">
        <button type="button" id="remove-btn" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 rounded-circle" style="width: 30px; height: 30px; padding: 0;">&times;</button>
    </div>

    <input id="dropzone-file" name="foto" type="file" class="d-none" accept="image/*" />
</label>