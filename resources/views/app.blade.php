<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Vite Manifest -->
    @vite(['resources/js/app.js', 'resources/css/app.css']) <!-- Corrigido para incluir o arquivo CSS e JS -->

    <!-- Inertia Head -->
    @inertiaHead
</head>
<body class="font-sans antialiased">
    <!-- Inertia will render the Vue components here -->
    @inertia
</body>
</html>
