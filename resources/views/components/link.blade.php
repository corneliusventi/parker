<a 
    href="{{ $url ?? '#' }}" 
    
    class="btn btn-{{ $color ?? 'primary' }} {{ $class ?? '' }} rounded"
    >

    {{ $slot }}
    
</a>