<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titre')</title>

        <!-- Style CSS (+ Bootstrap) -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    
    @yield('contenu')
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>