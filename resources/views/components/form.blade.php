<form
    @isset($id)
        id="{{ $id }}"
    @endisset

    @isset($class)
        class="{{ $class }}"
    @endisset

    @isset($action)
        action="{{ $action }}"
    @endisset

    @if(isset($enctype) && $enctype)
        enctype="{{ $enctype }}"
    @endif
    method="POST"
    >
    @isset($method)
        @method($method)
    @endisset


    @csrf

    {{ $slot }}

</form>
