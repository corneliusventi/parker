<a href="{{ route('parking-lot.show', $parkingLot->id) }}" class="btn btn-info"><i data-feather="info"></i></a>
<a href="{{ route('parking-lot.edit', $parkingLot->id) }}" class="btn btn-warning"><i data-feather="edit"></i></a>
<a href="{{ route('parking-lot.print', $parkingLot->id) }}" class="btn btn-secondary"><i data-feather="printer"></i></a>
<button type="button" data-toggle="modal" data-target="#deleteModal" data-parkinglot="{{ $parkingLot->id }}" class="btn btn-danger"><i data-feather="trash"></i></button>
