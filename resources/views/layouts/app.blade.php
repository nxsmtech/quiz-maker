<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filament + Livewire</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    @livewireStyles <!-- This loads Livewire's styles -->
</head>
<body>
<div>
    @yield('content')
</div>

@livewireScripts <!-- This loads Livewire's scripts -->
@vite('resources/js/app.js') <!-- Load JS via Vite -->
</body>
</html>
