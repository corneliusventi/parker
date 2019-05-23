@isset($show)
    <a href="{{ $show }}" class="btn btn-info"><i data-feather="info"></i></a>
@endisset

@isset($edit)
    <a href="{{ $edit }}" class="btn btn-warning"><i data-feather="edit"></i></a>
@endisset

@isset($delete)
    <a href="{{ $delete }}" data-toggle="modal" data-target="#deleteModal" data-url="{{ $delete }}" class="btn btn-danger"><i data-feather="trash"></i></a>
@endisset

@isset($print)
    <a href="{{ $print }}" class="btn btn-secondary"><i data-feather="printer"></i></a>
@endisset
