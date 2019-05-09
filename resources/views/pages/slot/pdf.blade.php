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
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div>
        <h1 style="font-size: 4em;">
            {{ $slot->code }}
        </h1>
        <div>
            <img src="data:image/png;base64, {{ $slot->qrcode }} ">
        </div>
    </div>

</body>
</html>
