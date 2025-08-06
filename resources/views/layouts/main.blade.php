<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>@yield('title', 'Página')</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="dns-prefetch" href="//fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/intern.css') }}" />
    <link rel="icon" type="image/x-icon" href="{{ asset('img/favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div id="app">

        <nav class="sidebar">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('img/logo.svg') }}" alt="Logo" style="width: 100px; height: 100px; display: block; margin: 0 auto;" />
                </a>
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Dashboard</a>
                </li>
                <li
                    class="{{ request()->routeIs('spends.*') || request()->routeIs('category_spends.*') ? 'active submenu-active' : '' }}">
                    <a href="{{ route('spends.index') }}"
                        class="has-chevron {{ request()->routeIs('spends.*') || request()->routeIs('category_spends.*') ? 'active' : '' }}">
                        Gastos
                    </a>
                    <ul class="submenu"
                        style="{{ request()->routeIs('spends.*') || request()->routeIs('category_spends.*') ? 'display: block;' : '' }}">
                        <li>
                            <a href="{{ route('category_spends.index') }}"
                                class="{{ request()->routeIs('category_spends.*') ? 'active' : '' }}">
                                Categorias
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a href="{{ route('gains.index') }}" class="{{ request()->routeIs('gains.*') ? 'active' : '' }}">Ganhos</a></li>
                <li><a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">Relatórios</a></li>
            </ul>
        </nav>

        <nav class="topbar">
            <div class="user-name dropdown">
                Olá, {{ Auth::user()->name ?? 'Usuário' }}
                <span class="chevron"></span>
                <div class="dropdown-menu">
                    <a href="{{ route('profile.edit') }}">Editar Perfil</a>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sair
                    </a>
                </div>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </nav>

        <main class="content">
            @yield('content')
            @yield('styles')
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
            @yield('scripts')
        </main>
    </div>
    @if ($errors->any())
        <script>
            toastr.error("Erro: {{ $errors->first() }}", '', {
                timeOut: 5000,
                closeButton: true,
                progressBar: true,
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                toastr.error(@json(session('error')), 'Erro', {
                    timeOut: 5000,
                    closeButton: true,
                    progressBar: true
                });
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                toastr.success(@json(session('success')), 'Sucesso', {
                    timeOut: 5000,
                    closeButton: true,
                    progressBar: true
                });
            });
        </script>
    @endif

    <style>
        #toast-container {
            top: 70px !important;
            z-index: 99999 !important;
        }

        .toast-success {
            background-color: #28a745 !important;
            color: white !important;
            opacity: 1 !important;
        }

        .toast-error {
            background-color: #dc3545 !important;
            color: white !important;
            opacity: 1 !important;
        }

        .toast-title {
            font-weight: bold;
        }
    </style>
</body>

</html>
