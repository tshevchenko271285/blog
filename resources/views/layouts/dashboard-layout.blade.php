<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        @auth
            <header class="dashboard-admin-header">
                <div class="container">
                    <nav class="dashboard-admin-header__menu">
                        <a href="{{ route( 'posts.index' ) }}" type="button" class="btn btn-success dashboard-admin-header__menu-item">{{ __('All post') }}</a>
                        <a href="{{ route( 'posts.create' ) }}" type="button" class="btn btn-success dashboard-admin-header__menu-item">{{ __('Create post') }}</a>
                        <a href="#" type="button" class="btn btn-success dashboard-admin-header__menu-item">{{ __('Profile') }}</a>
                    </nav>
                </div>
            </header>
        @endauth

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
