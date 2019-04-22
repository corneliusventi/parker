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
    
    method="POST"
    >
    @isset($method)
        @method($method)
    @endisset

    @csrf
    
    {{ $slot }}

</form>
