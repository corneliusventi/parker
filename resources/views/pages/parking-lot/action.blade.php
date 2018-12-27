<a href="{{ route('parking-lot.print', $parkingLot->id) }}" class="btn btn-success">Print</a>
<a href="{{ route('parking-lot.edit', $parkingLot->id) }}" class="btn btn-warning">Edit</a>
<button type="button" data-toggle="modal" data-target="#deleteModal" data-parkinglot="{{ $parkingLot->id }}" class="btn btn-danger">Delete</button>
