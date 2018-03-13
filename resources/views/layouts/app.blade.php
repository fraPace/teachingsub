<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <!-- Navigation Links -->
                        @role('admin')
                            <li><a class="nav-link" href="{{ route('admin.home') }}">{{ __('Admin') }}</a></li>
                            <li><a class="nav-link" href="{{ route('users.index') }}">{{ __('Users') }}</a></li>
                        @endrole
                        @auth
                            <li><a class="nav-link" href="{{ route('courses.index') }}">{{ __('Courses') }}</a></li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @role('admin|professor|ta')
                                        <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">{{ __('Edit Profile') }}</a>
                                    @endrole
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @if (session('status-success'))
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="alert alert-success">
                            {{ session('status-success') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (session('status-danger'))
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="alert alert-danger">
                            {{ session('status-danger') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (session('status-info'))
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="alert alert-info">
                            {{ session('status-info') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (session('status-warning'))
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="alert alert-warning">
                            {{ session('status-warning') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @if (count($errors) > 0 && old('modal_id'))
        <script type="text/javascript">
            window.$(document).ready(function() {
                $('#{{old('modal_id')}}').modal({show: true});
            });
        </script>
    @endif
</body>
</html>
