<div class="form-group">
    <label for="{{ $id ?? $name }}">
        {{ $slot }}
    </label>
    <select
        class="custom-select"
        name="{{ $name }}"
        id="{{ $id ?? $name }}"
        {{ isset($required)  ? 'required' : '' }}
        {{ isset($disabled) ? 'disabled' : '' }}
        {{ isset($readonly) ? 'readonly' : '' }}
        >
        @foreach ($options as $option)

            @if (is_array($option))
                <option
                    value="{{ $option['value'] }}"
                    {{ isset($selected) && $option['value'] == $selected ? 'selected' : '' }}
                    >
                    {{ $option['text'] }}
                </option>
            @else
                <option
                    value="{{ $option->option_value }}"
                    {{ isset($selected) && $option->is($selected) ? 'selected' : '' }}
                    >
                    {{ $option->option_text }}
                </option>
            @endif
        @endforeach
    </select>

    @if($errors->first($name))
        <small class="form-text text-danger">
            {{ $errors->first($name) }}
        </small>
    @endif
</div>