<div class="form-group">
    <label>
        {{ $slot }}
    </label>
    <div class="input-group">
        <input
            type="text"
            class="form-control"
            name="{{ $latitude['name'] }}"
            id="{{ $latitude['id'] ?? $latitude['name'] }}"
            placeholder="{{ $latitude['placeholder'] }}"
            value="{{ $latitude['value'] ?? old($latitude['name']) }}"
            {{ isset($latitude['required'])  ? 'required' : '' }}
            {{ isset($latitude['disabled']) ? 'disabled' : '' }}
            {{ isset($latitude['readonly']) ? 'readonly' : '' }}
            >
        <input
            type="text"
            class="form-control"
            name="{{ $longitude['name'] }}"
            id="{{ $longitude['id'] ?? $longitude['name'] }}"
            placeholder="{{ $longitude['placeholder'] }}"
            value="{{ $longitude['value'] ?? old($longitude['name']) }}"
            {{ isset($longitude['required'])  ? 'required' : '' }}
            {{ isset($longitude['disabled']) ? 'disabled' : '' }}
            {{ isset($longitude['readonly']) ? 'readonly' : '' }}
            >
    </div>
    @if($errors->first($latitude['name']))
        <small class="form-text text-danger">
            {{ $errors->first($latitude['name']) }}
        </small>
    @endif

    @if($errors->first($longitude['name']))
        <small class="form-text text-danger">
            {{ $errors->first($longitude['name']) }}
        </small>
    @endif

    <div class="mt-4">
        {!! $map['html'] !!}
    </div>

</div>

@push('js')
    {!! $map['js'] !!}
@endpush