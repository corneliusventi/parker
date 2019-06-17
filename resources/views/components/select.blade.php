<div class="form-group">
    <label for="{{ $id ?? $name }}">
        {{ $slot }}
    </label>
    <select
        class="custom-select"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        {{ isset($required) && $required ? 'required' : '' }}
        {{ isset($disabled) && $disabled ? 'disabled' : '' }}
        {{ isset($readonly) && $readonly ? 'readonly' : '' }}
        {{ isset($multiple) && $multiple ? 'multiple' : '' }}
        >
        @foreach ($options as $option)

            @if (is_array($option))
                <option
                    value="{{ $option['value'] }}"
                    @if (isset($multiple) && $multiple)
                        {{ isset($selected) && in_array($option['value'], $selected) ? 'selected' : '' }}
                    @else
                        {{ isset($selected) && $option['value'] == $selected ? 'selected' : '' }}
                    @endif
                    >
                    {{ $option['text'] }}
                </option>
            @else
                <option
                    value="{{ $option->option_value }}"
                    @if (isset($multiple) && $multiple)
                        {{ isset($selected) && $selected->contains($option) ? 'selected' : '' }}
                    @else
                        {{ isset($selected) && $option->is($selected) ? 'selected' : '' }}
                    @endif
                    >
                    {{ $option->option_text }}
                </option>
            @endif
        @endforeach
    </select>

    @if($errors->first(preg_replace("/[^a-zA-Z]/", "", $name)))
        <small class="form-text text-danger">
            {{ $errors->first(preg_replace("/[^a-zA-Z]/", "", $name)) }}
        </small>
    @endif
</div>