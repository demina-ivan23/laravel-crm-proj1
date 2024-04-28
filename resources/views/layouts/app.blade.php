<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Tailwind -->
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            @auth
                <div class="sidebar-btn-container d-flex justify-content-start">
                    <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                        aria-controls="offcanvasExample">
                        <img src="/web_icons/sidebar-icon.png" alt="sidebar-icon" width="40">
                    </button>
                </div>
            @endauth
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    @if (auth()->user()->is_superadmin)
                                        <a href="{{ route('superadmin.index') }}" class="dropdown-item">
                                            Dashboard
                                        </a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasExample"
                aria-labelledby="offcanvasExampleLabel" style="width: 250px;">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Laravel CRM Sidebar</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#userMenu" role="button"
                                    aria-expanded="false" aria-controls="userMenu">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="collapse" id="userMenu">
                                    <ul class="navbar-nav">
                                        @if (auth()->user()->is_superadmin)
                                            <li class="ml-7">
                                                <a href="{{route('superadmin.index')}}" class="dropdown-item" style="{{ request()->routeIs('superadmin.index') ? 'color:gray' : '' }}">Superadmin Dashboard</a>
                                            </li>
                                            <li class="mt-2 d-flex justify-content-center" style="font-weight: 700">
                                                <p>Chart Links</p>
                                            </li>
                                            <li class="ml-7">
                                                <a href="{{route('superadmin.order_chart')}}" class="dropdown-item" style="{{ request()->routeIs('superadmin.order_chart') ? 'color:gray' : '' }}">Order info page</a>
                                            </li>
                                            <li class="ml-7">
                                                <a href="{{route('superadmin.order_product_chart')}}" class="dropdown-item" style="{{ request()->routeIs('superadmin.order_product_chart') ? 'color:gray' : '' }}">Order-Product info page</a>
                                            </li>
                                            <li class="ml-7">
                                                <a href="{{route('superadmin.order_prospect_chart')}}" class="dropdown-item" style="{{ request()->routeIs('superadmin.order_prospect_chart') ? 'color:gray' : '' }}">Order-Prospect info page</a>
                                            </li>
                                            <li class="mt-2 d-flex justify-content-center" style="font-weight: 700">
                                                <p>Order Status Links</p>
                                            </li>
                                            <li class="ml-7">
                                                <a href="{{route('superadmin.order_statuses.index')}}" class="dropdown-item" style="{{ request()->routeIs('superadmin.order_statuses.index') ? 'color:gray' : '' }}">All Order Statuses</a>
                                            </li>
                                            <li class="ml-7">
                                                <a href="{{route('superadmin.order_statuses.create')}}" class="dropdown-item" style="{{ request()->routeIs('superadmin.order_statuses.create') ? 'color:gray' : '' }}">Create Order Status</a>
                                            </li>
                                        @endif
                                        <li class="nav-item ml-5">
                                            <a class="nav-link" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#productsMenu" role="button"
                                    aria-expanded="false" aria-controls="productsMenu">
                                    Products
                                </a>
                                <div class="collapse" id="productsMenu">
                                    <ul class="navbar-nav">
                                        <li class="nav-item ml-5">
                                            <a href="{{ route('admin.products.dashboard') }}" class="nav-link">Manage</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#prospectsMenu" role="button"
                                    aria-expanded="false" aria-controls="prospectsMenu">
                                    Prospects
                                </a>
                                <div class="collapse" id="prospectsMenu">
                                    <ul class="navbar-nav">
                                        <li class="nav-item ml-5">
                                            <a href="{{ route('admin.prospects.dashboard') }}"
                                                class="nav-link">Manage</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="collapse" href="#ordersMenu" role="button"
                                    aria-expanded="false" aria-controls="ordersMenu">
                                    Orders
                                </a>
                                <div class="collapse" id="ordersMenu">
                                    <ul class="navbar-nav">
                                        <li class="nav-item ml-5">
                                            <a href="{{ route('admin.orders.dashboard') }}" class="nav-link">Manage</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endguest
                    </ul>

                </div>
            </div>
            @yield('content')
        </main>
    </div>
</body>

</html>
