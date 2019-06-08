<a href="{{ route('top-ups.show', $topUp->id) }}" class="btn btn-secondary"><i data-feather="info"></i></a>
@if (is_null($topUp->approved))

<a href="{{ route('top-ups.approve', $topUp->id) }}" data-toggle='modal' data-target='#approveModal'
    data-url='{{ route('top-ups.approve', $topUp->id) }}' class="btn btn-success"><i data-feather="check"></i></a>
<a href="{{ route('top-ups.disapprove', $topUp->id) }}" data-toggle='modal' data-target='#disapproveModal'
    data-url='{{ route('top-ups.disapprove', $topUp->id) }}' class="btn btn-danger"><i data-feather="x"></i></a>

@endif