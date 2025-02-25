<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @vite('resources/js/bootstrap.js')
    @livewireStyles
    <title>@yield('title')</title>
</head>
<body>
    @yield('content')
    @livewireScripts
</body>
</html>