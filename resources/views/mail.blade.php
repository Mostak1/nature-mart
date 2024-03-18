<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>
<body>
    <div class="">
<div class="fs-2 text-center">{{ $name }} Order Information</div>

        <div class="fs-4">Item: Black Rice Flower</div>
        <div class="fs-4">Name: {{ $name }}</div>
        <div class="fs-4">Address: {{ $address }}</div>
        <div class="fs-4">Phone: {{ $phone }}</div>
        <div class="fs-4">Email: {{ $email }}</div>
        <div class="fs-4">Total: {{ $total }} TK Only</div>
        <div class="fs-4">Quantity: {{ $quantity }}</div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>


