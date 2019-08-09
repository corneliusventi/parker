<a
    href="{{ $url ?? '#' }}"

    class="btn btn-block btn-{{ $color ?? 'primary' }} {{ $class ?? '' }} rounded"
    >

    {{ $slot }}

</a>