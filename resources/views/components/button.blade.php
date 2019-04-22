<button
    type="{{ $type ?? 'button' }}"
     
    @isset($id)
        id="{{ $id }}"
    @endisset    

    @isset($data)
        @foreach($data as $name => $value)
            data-{{ $name }}="{{ $value }}"
        @endforeach 
    @endisset

    class="btn btn-{{ $color ?? 'primary' }} {{ $class ?? '' }}">

    {{ $slot }}

</button>
