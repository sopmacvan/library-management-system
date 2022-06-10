<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Laravel') }}</title>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!-- Fonts -->
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

<!-- Styles -->
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="/css/styles.css">
</head>
<body>
<!-- top navbar -->
<nav class="navbar navbar-expand-lg
            navbar-light bg-primary">
    <a class="navbar-brand" href="{{ url('/') }}">Library Management System</a>
    <!-- hamburger button that toggles the navbar-->
    <button class="navbar-toggler" type="button"
            data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
            </span>
    </button>
    {{--    <!-- navbar links -->--}}
    {{--    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">--}}
    {{--        <div class="navbar-nav">--}}
    {{--            <a class="nav-item nav-link--}}
    {{--                    active" href="#">--}}
    {{--                Home--}}
    {{--            </a>--}}
    {{--            <a class="nav-item nav-link" href="#">Features</a>--}}
    {{--            <a class="nav-item nav-link" href="#">Price</a>--}}
    {{--            <a class="nav-item nav-link" href="#">About</a>--}}
    {{--        </div>--}}
    {{--    </div>--}}
</nav>
<!-- This container contains the sidebar
        and main content of the page -->
<!-- h-100 takes the full height of the body-->
@guest
    <ul class="nav-item fixe">
        @if (Route::has('login'))
            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
        @endif

        @if (Route::has('register'))
            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
        @endif
    </ul>

@else
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-2" id="green">
                <h4>Welcome, {{ Auth::user()->name }}
                </h4>
                <!-- Navigation links in sidebar-->
                @if (Auth::user()->getRole() == 'user')
                    <a class="nav-link" href="{{ route('user') }}">{{ __('Home') }}</a>
                    <a class="nav-link" href="{{ route('books') }}">{{ __('Books') }}</a>
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Borrowed Books') }}</a>
                    <a class="nav-link" href="{{ route('reserved-books') }}">{{ __('Reserved Books') }}</a>
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Transaction History') }}</a>
                @endif
                @if(Auth::user()->getRole() == 'admin')
                    <a class="nav-link" href="{{ route('admin') }}">{{ __('Home') }}</a>
                    <a class="nav-link" href="{{ route('manage-users') }}">{{ __('Manage Users') }}</a>
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Manage Borrowed Books') }}</a>
                    <a class="nav-link"
                       href="{{ route('manage-reserved-books') }}">{{ __('Manage Reserved Books') }}</a>
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Transaction History') }}</a>
                @endif
                <a class="nav-link " href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
            <!--Contains the main content
                    of the webpage-->
            <div class="col-10" style="text-align: justify;">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
@endguest

@yield('auth_content')

</body>

{{--<body>--}}


{{--<div id="app">--}}
{{--    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">--}}
{{--        <div class="container">--}}
{{--            <a class="navbar-brand" href="{{ url('/') }}">--}}
{{--                {{ config('app.name', 'Laravel') }}--}}
{{--            </a>--}}
{{--            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"--}}
{{--                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"--}}
{{--                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">--}}
{{--                <span class="navbar-toggler-icon"></span>--}}
{{--            </button>--}}

{{--            <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
{{--                <!-- Left Side Of Navbar -->--}}
{{--                <ul class="navbar-nav me-auto">--}}

{{--                </ul>--}}

{{--                <!-- Right Side Of Navbar -->--}}
{{--                <ul class="navbar-nav ms-auto">--}}
{{--                    <!-- Authentication Links -->--}}
{{--                    @guest--}}
{{--                        @if (Route::has('login'))--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
{{--                            </li>--}}
{{--                        @endif--}}

{{--                        @if (Route::has('register'))--}}
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                    @else--}}
{{--                        Navigation Bars--}}
{{--                        <li class="nav-item">--}}
{{--                            @if (Auth::user()->getRole() == 'user')--}}
{{--                                <a class="nav-link" href="{{ route('user') }}">{{ __('Home') }}</a>--}}
{{--                                <a class="nav-link" href="{{ route('books') }}">{{ __('Books') }}</a>--}}
{{--                                <a class="nav-link" href="{{ route('login') }}">{{ __('Borrowed Books') }}</a>--}}
{{--                                <a class="nav-link" href="{{ route('reserved-books') }}">{{ __('Reserved Books') }}</a>--}}
{{--                                <a class="nav-link" href="{{ route('login') }}">{{ __('Transaction History') }}</a>--}}
{{--                            @endif--}}
{{--                            @if(Auth::user()->getRole() == 'admin')--}}
{{--                                <a class="nav-link" href="{{ route('admin') }}">{{ __('Home') }}</a>--}}
{{--                                <a class="nav-link" href="{{ route('login') }}">{{ __('Manage Borrowed Books') }}</a>--}}
{{--                                <a class="nav-link"--}}
{{--                                   href="{{ route('manage-reserved-books') }}">{{ __('Manage Reserved Books') }}</a>--}}
{{--                                <a class="nav-link" href="{{ route('login') }}">{{ __('Transaction History') }}</a>--}}
{{--                            @endif--}}
{{--                            <a class="nav-link" href="{{ route('logout') }}"--}}
{{--                               onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                                {{ __('Logout') }}--}}
{{--                            </a>--}}

{{--                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
{{--                                @csrf--}}
{{--                            </form>--}}
{{--                        </li>--}}

{{--                        <li class="nav-item dropdown">--}}
{{--                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"--}}
{{--                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
{{--                                {{ Auth::user()->name }}--}}
{{--                            </a>--}}

{{--                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">--}}
{{--                                <a class="dropdown-item" href="{{ route('logout') }}"--}}
{{--                                   onclick="event.preventDefault();--}}
{{--                                                     document.getElementById('logout-form').submit();">--}}
{{--                                    {{ __('Logout') }}--}}
{{--                                </a>--}}

{{--                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">--}}
{{--                                    @csrf--}}
{{--                                </form>--}}
{{--                            </div>--}}
{{--                        </li>--}}
{{--                    @endguest--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}


{{--    </nav>--}}

{{--    <main class="py-4">--}}
{{--        @yield('content')--}}
{{--    </main>--}}
{{--</div>--}}
{{--</body>--}}
</html>
