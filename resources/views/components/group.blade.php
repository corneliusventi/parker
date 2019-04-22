<div 
    class="input-group {{ $class ?? '' }}"
    
    @isset($id)
        id="{{ $id }}"
    @endisset

    >

    @isset($prepend)
        <div class="input-group-prepend">
            {{ $prepend }}
        </div>
    @endisset

    {{ $slot }}
    
    @isset($append)
        <div class="input-group-append">
            {{ $append }}
        </div>
    @isset
</div>
