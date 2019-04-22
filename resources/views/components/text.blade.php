<input
    type="text"
    
    @isset($id)
        id="{{ $id }}"
    @endisset

    @isset($name)
        name="{{ $name }}"
    @endisset

    class="form-control {{ $class ?? '' }}"

    @isset($placeholder)
        placeholder="{{ $placeholder }}"
    @endisset
    
    >
