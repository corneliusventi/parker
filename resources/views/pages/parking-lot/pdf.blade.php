<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Parking Lot</title>
    <style>
        body {
            text-align: center;
        }
    </style>
</head>
<body>
    <div>
        <h1>
            PARKER
        </h1>
        <h2>
            Parkir Keren
        </h2>
        <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->merge('/public/apple-icon.png')->size(500)->generate("PARKER$parkingLot->id")) }} ">
        <h3>
            {{ $parkingLot->name }}
        </h3>
        <h4>
            {{ $parkingLot->address }}
        </h4>
    </div>
</body>
</html>
