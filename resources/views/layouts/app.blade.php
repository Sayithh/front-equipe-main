
@php use App\Utils\SessionHelpers; @endphp
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hackat'innov @yield('title', '')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/main.css" rel="stylesheet"/>
    <link rel="shortcut icon" href="/img/logo.png">

    @yield('custom-css', '')

    <style>
        [v-cloak] {
            display: none !important;
        }
    </style>
</head>

<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="sticky-top header">
    <header class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills w-100 d-flex">
            <li class="nav-item">
                <a href="/" class="nav-link white-link">
                    <img src="/img/logo.png" alt="Logo" style="height: 30px;">
                </a>
            </li>
            <li class="nav-item"><a href="{{ route('about') }}" class="nav-link white-link @if (Route::is('about')) {{'active-link'}} @endif">About</a></li>
            <li class="nav-item"><a href="{{ route('hackathon.index') }}" class="nav-link white-link @if (Route::is('hackathon.index')) {{'active-link'}} @endif">Hackathons</a></li>
            <li class="flex-grow-1"></li>
        
            @if (!SessionHelpers::isConnected())
                <li class="nav-item"><a href="{{ route('login') }}" class="nav-link white-link @if (Route::is('login')) {{'active-link'}} @endif">Login</a></li>
            @else
                <li class="nav-item"><a href="/me" class="nav-link white-link @if (Route::is('me')) {{'active-link'}} @endif">Mon profil</a></li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link white-link">Déconnexion</button>
                    </form>
                </li>
            @endif
            <li class="nav-item">
                @if(Auth::guard('admin')->check())
                    <a href="{{ route('doc-api') }}" class="nav-link white-link">🔐 API</a>
                    <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link white-link">Se déconnecter</button>
                    </form>
                @else
                    <a href="{{ route('admin.login') }}" class="nav-link white-link">🔐 API</a>
                @endif
            </li>
        </ul>
    </header>
</div>

<!-- Contenu de la page, sera remplacé par le contenu de la page appelée (section('content')) -->
@yield('content', 'Default content')

</body>
</html>