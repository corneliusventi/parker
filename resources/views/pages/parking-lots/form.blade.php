@input([
    'type' => 'text',
    'name' => 'name',
    'required' => true,
    'value' => isset($parkingLot) ? $parkingLot->name : old('name'),
])
    Name
@endinput

@select([
    'name' => 'type',
    'required' => true,
    'options' => [
        ['value' => 'street', 'text' => 'Street'],
        ['value' => 'building', 'text' => 'Building'],
    ],
    'selected' => isset($parkingLot) ? $parkingLot->type : old('type'),
])
    Type
@endselect

@input([
    'type' => 'text',
    'name' => 'address',
    'required' => true,
    'value' => isset($parkingLot) ? $parkingLot->address : old('address'),
])
    Address
@endinput

@select([
    'name' => 'operators[]',
    'required' => true,
    'options' => $operators,
    'multiple' => true,
    'selected' => isset($parkingLot) ? $parkingLot->users : old('operators'),
])
    Operator
@endselect

@map([
    'map' => $map,
    'latitude' => [
        'name' => 'latitude',
        'placeholder' => 'Latitude',
        'value' => isset($parkingLot) ? $parkingLot->latitude : old('latitude'),
        'readonly' => true,
        'required' => true
    ],
    'longitude' => [
        'name' => 'longitude',
        'value' => isset($parkingLot) ? $parkingLot->longitude : old('longitude'),
        'placeholder' => 'Longitude',
        'readonly' => true,
        'required' => true
    ],

])
    Latitude & Longitude
@endmap

<div class="form-group">
    <label for="blueprint">Blueprint</label>
    <div class="input-group mb-3">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="blueprint" name="blueprint" accept="image/*"
                required>
            <label id="blueprint_label" class="custom-file-label" for="blueprint">Choose Blueprint</label>
        </div>
    </div>
    <div id="blueprint_preview" style="height:300px;" class="border border-primary rounded"></div>
</div>

@push('js')
    <script src="/js/jquery.uploadPreview.min.js"></script>
    <script>
        $(document).ready(function() {
            $.uploadPreview({
                input_field: "#blueprint", // Default: .image-upload
                preview_box: "#blueprint_preview", // Default: .image-preview
                label_field: "#blueprint_label", // Default: .image-label
                label_default: "Choose Blueprint", // Default: Choose File
                label_selected: "Change Blueprint", // Default: Change File
                no_label: false // Default: false
            });
        });
    </script>
@endpush