<label 
    @isset($for)
        for="{{ $for }}"
    @endisset
    >

    {{ $slot }}

</label>
