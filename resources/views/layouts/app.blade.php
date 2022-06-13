<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title> BookHub </title>

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

<!-- Bootstrap Font Icon CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>
<body>
<head>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg" style="background-color: #1BB2B3;">
    <a class="navbar-brand" href="{{ url('/') }}" style="color: white; padding: 10px; font-weight: bold; font-size: 28px;"><span class="bi-book-half"></span> BookHub Library Management System</a>
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

@else
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-2" style="background-color: white; text-align: center;">
                <div class="row mb-3"></div>
                <h4 style="font-weight: bold;" >Welcome, {{ Auth::user()->name }}</h4>
                <!-- USER'S ICON -->
                <i class="bi-person-circle" style="font-size: 100px;"></i>

                <!-- USER'S PAGE -->
                <!-- Navigation links in sidebar-->
                @if (Auth::user()->hasRole('user'))
                    <a id="txtBtn" class="nav-link" href="{{ route('user') }}"><span class="bi-house"></span>{{ __(' Home') }}</a>
                    <a id="txtBtn" class="nav-link" href="{{ route('books') }}"><span class="bi-journals"></span>{{ __(' Books') }}</a>
                    <a id="txtBtn" class="nav-link" href="{{ route('login') }}"><span class="bi-check-all"></span>{{ __(' Borrowed Books') }}</a>
                    <a id="txtBtn" class="nav-link" href="{{ route('reserved-books') }}"><span class="bi-hand-thumbs-up"></span>{{ __(' Reserved Books') }}</a>
{{--                    <a id="txtBtn" class="nav-link" href="{{ route('login') }}"><span class="bi-clock-history"></span>{{ __(' Transaction History') }}</a>--}}
                @endif

                <!-- ADMIN'S PAGE-->
                @if(Auth::user()->hasRole('admin'))
                    <a id="txtBtn" class="nav-link" href="{{ route('admin') }}"><span class="bi-house"></span>{{ __(' Home') }}</a>
                    <a id="txtBtn" class="nav-link" href="{{ route('manage-users') }}"><span class="bi-gear"></span>{{ __(' Manage Users') }}</a>
                    <a id="txtBtn" class="nav-link" href="{{ route('manage-books') }}"><span class="bi-gear"></span>{{ __(' Manage Books') }}</a>
                    <a id="txtBtn" class="nav-link" href="{{ route('login') }}"><span class="bi-journal-code"></span>{{ __(' Manage Borrowed Books') }}</a>
                    <a id="txtBtn" class="nav-link"
                       href="{{ route('manage-reserved-books') }}"><span class="bi-journal-check"></span>{{ __(' Manage Reserved Books') }}</a>
                    <a id="txtBtn" class="nav-link" href="{{ route('login') }}"><span class="bi-clock-history"></span>{{ __(' Transaction History') }}</a>
                @endif
                <a id="txtBtn" class="nav-link " href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><span class="bi-box-arrow-left"></span>
                    {{ __(' Logout') }}
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
