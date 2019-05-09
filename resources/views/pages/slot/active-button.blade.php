@if ($slot->active)
    <button class="btn btn-outline-primary slot" type="button" data-id="{{ $slot->id }}">
        Active
    </button>
@else
    <button class="btn btn-outline-danger slot" type="button" data-id="{{ $slot->id }}">
        Disable 
    </button>
@endif