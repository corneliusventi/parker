@if ((isset($if) && $if) || !isset($if))
    {{ $slot }}
@endif