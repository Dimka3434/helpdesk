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
                {{ config('app.name', 'Helpdesk') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <form action="{{ route('complains.search') }}">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="input-group">
                        <input type="text" name="id" class="form-control" placeholder="Номер заявки">
                        <button class="btn btn-info text-white">Проверить заявку</button>
                </div>
            </div>
            </form>
        </div>
    </nav>
    <main class="container">
        <div class="row mt-2">
            <div class="col"></div>
            <div class="col-8">
                <div class="card w-100">
                    @if (View::hasSection('header'))
                    <div  class="card-header">
                        @yield('header')
                    </div>
                    @endif
                    <div class="card-body">
                        @yield('content')
                    </div>
                    @if (View::hasSection('footer'))
                    <div class="card-footer">
                        @yield('footer')
                    </div>
                    @endif
                </div>
            </div>
            <div class="col"></div>
        </div>
    </main>
</div>
</body>
</html>
