<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>InkSpire</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #FEFEFD;
        }
        .btn-welcome {
            background-color: #0D95D2;
            border-color: #0D95D2;
            color: white;
            font-weight: 700;
            border-radius: 50px;
            padding: 10px 30px;
            margin: 5px;
        }
        .btn-welcome:hover {
            background-color: #0b7eb5;
            color: white;
        }
    </style>
</head>
<body>
    @include('partials.header')

    <div class="container text-center" style="margin-top: 20vh;">
        <h1 class="fw-bold mb-4">InkSpire</h1>
        <p class="lead mb-4">Your favorite printing supplies, just a click away.</p>
        <a href="{{ route('login') }}" class="btn btn-welcome">Login</a>
        <a href="{{ route('register') }}" class="btn btn-welcome">Register</a>
    </div>
</body>
</html>