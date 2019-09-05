<a
    @isset($id)
        id='{{ $id }}'
    @endisset
    href="{{ $url ?? '#' }}"

    class="btn btn-block btn-{{ $color ?? 'primary' }} {{ $class ?? '' }} rounded"
    >

    {{ $slot }}

</a>