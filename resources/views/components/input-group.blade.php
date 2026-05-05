<div class="mb-3">
    <label for="{{ $name }}" class="form-label fw-semibold">
        {{ $label }}
    </label>

    <div class="input-group">
        <span class="input-group-text">
            <i class="bi {{ $icon }}"></i>
        </span>

        <!-- Input (se muestra si se pasó type) -->
        @isset($type)
            <input 
                type="{{ $type }}"
                name="{{ $name }}"
                id="{{ $name }}"
                value="{{ old($name, $value) }}"
                {{ $attributes->merge([
                    'class' => 'form-control ' . ($errors->has($name) ? 'is-invalid' : '')
                ]) }}
            >
        @endisset

        <!-- Select (se muestra si se pasó el slot) -->
        @isset($select)
            {{ $select }}
        @endisset

        <!-- Button (se muestra si se pasó el slot) -->
        @isset($button)
            {{ $button }}
        @endisset

        @error($name)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>