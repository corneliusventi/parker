<div class="form-group">
    <label for="{{ $id ?? $name }}">
        {{ $slot }}
    </label>
    <input
        type="{{ $type ?? 'text' }}"
        class="form-control"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        placeholder="{{ $placeholder ?? $slot }}"
        value="{{ $value ?? old($name) }}"
        {{ isset($min) && $type == 'number' ? 'min='.$min : '' }}
        {{ isset($required) && $required ? 'required' : '' }}
        {{ isset($disabled) && $disabled ? 'disabled' : '' }}
        {{ isset($readonly) && $readonly ? 'readonly' : '' }}
        >

    @if($errors->first($name))
        <small class="form-text text-danger">
            {{ $errors->first($name) }}
        </small>
    @endif
</div>