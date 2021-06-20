<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                </ul>
                <ul class="navbar-nav ml-auto">
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Войти в систему</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            {{ Auth::user()->name }}
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 mt-3 d-md-block bg-light sidebar collapse">
                @auth
                    <div class="card">
                        <div class="card-body">
                            @if(auth()->user()->type === 0)
                                <div class="position-sticky pt-3">
                                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                        <span class="fs-5 fw-bolder">Диспетчерская</span>
                                        <a class="link-secondary" href="#" aria-label="Add a new report">
                                            <span data-feather="plus-circle"></span>
                                        </a>
                                    </h6>
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="/problems">
                                                Заявки @if($opened_problems_count)<span class="text-danger">({{$opened_problems_count}})</span>@endif
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/users">
                                                Пользователи
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="/categories">
                                                Настройки системы
                                            </a>
                                        </li>
                                    </ul>
                                    @endif
                                    @if(auth()->user()->type === 1)
                                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                            <span class="fs-5 fw-bolder">Обслуживание</span>
                                            <a class="link-secondary" href="#" aria-label="Add a new report">
                                                <span data-feather="plus-circle"></span>
                                            </a>
                                        </h6>
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link" href="/performer/problems">
                                                    Поступившие заяввки @if($assigned_problems_count)<span
                                                        class="text-danger">({{$assigned_problems_count}})</span>@endif
                                                </a>
                                            </li>
                                        </ul>
                                    @endif
                                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                                        <span class="fs-5 fw-bolder">Личный кабинет</span>
                                        <a class="link-secondary" href="#" aria-label="Add a new report">
                                            <span data-feather="plus-circle"></span>
                                        </a>
                                    </h6>
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="/account/problems">
                                                Мои заявки
                                            </a>
                                            <a class="nav-link" href="{{ route('logout') }}"
                                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                Выйти из системы
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                        </div>
                @endauth
            </nav>
            <main class="col-md ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</div>
</div>
</body>
</html>
