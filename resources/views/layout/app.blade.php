<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>


        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">


    </head>

    <body>
        <div id="app">
            <nav class="navbar navbar-expand-md navbar-light navbar-laravel fixed-top">
                <div class="container-fluid">
                    <div class="navbar-header">

                        <a class="navbar-brand" href="{{ url('/dashboard') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/dashboard">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/maillist">Mailing List</a>
                            </li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">

                        </ul>
                    </div>
                </div>
            </nav>


            <main>
                @if(session('status'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>{{ session('status') }}</strong>
                    </div>
                @endif

                @yield('content')
            </main>

            @include('layout.footer')

        </div>
        <!-- Scripts -->
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    </body>
</html>