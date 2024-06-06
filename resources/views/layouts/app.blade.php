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
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>

                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="offcanvasExample"
                aria-labelledby="offcanvasExampleLabel" style="width: 300px;">
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
                                        <li class="mt-2 ml-3" style="font-weight: 700">
                                            <p>Dashboards</p>
                                        </li>

                                        @can('view-charts')
                                            <li class="mt-2 d-flex justify-content-center" style="font-weight: 700">
                                                <p>Charts</p>
                                            </li>

                                            <li class="ml-7">
                                                <a href="{{ route('dashboards.order-charts', ['tablink' => 'orderChart', 'tab-button' => 'orderChartTabToggle']) }}"
                                                    class="dropdown-item"
                                                    style="{{ request()->routeIs('dashboards.order-charts') && request()->query('tablink') == 'orderChart' ? 'color:gray' : '' }}">Order
                                                    info page</a>
                                            </li>
                                            <li class="ml-7">
                                                <a href="{{ route('dashboards.order-charts', ['tablink' => 'productChart', 'tab-button' => 'productChartTabToggle']) }}"
                                                    class="dropdown-item"
                                                    style="{{ request()->routeIs('dashboards.order-charts') && request()->query('tablink') == 'productChart' ? 'color:gray' : '' }}">Order-Product
                                                    info page</a>
                                            </li>
                                        @endcan
                                        @can('states-dashboard')
                                            <li class="mt-2 d-flex justify-content-center" style="font-weight: 700">
                                                <p>States</p>
                                            </li>
                                            @can('view', App\Models\OrderStatus::class)
                                                <li class="ml-7">
                                                    <a href="{{ route('dashboards.states', ['tablink' => 'orderStatuses', 'tab-button' => 'orderStatusesTabToggle']) }}"
                                                        class="dropdown-item"
                                                        style="{{ request()->routeIs('dashboards.states') && request()->query('tablink') == 'orderStatuses' ? 'color:gray' : '' }}">Order
                                                        Statuses</a>
                                                </li>
                                            @endcan
                                            @can('view', App\Models\ProspectState::class)
                                                <li class="ml-7">
                                                    <a href="{{ route('dashboards.states', ['tablink' => 'prospectStates', 'tab-button' => 'prospectStatesTabToggle']) }}"
                                                        class="dropdown-item"
                                                        style="{{ request()->routeIs('dashboards.states') && request()->query('tablink') == 'prospectStates' ? 'color:gray' : '' }}">Prospect
                                                        States</a>
                                                </li>
                                            @endcan
                                        @endcan
                                        @can('users-roles-dashboard')
                                            <li class="mt-2 d-flex justify-content-center" style="font-weight: 700">
                                                <p>User-Role</p>
                                            </li>
                                            @can('view', App\Models\User::where('id','!=',auth()->id())->first())
                                                <li class="ml-7">
                                                    <a href="{{ route('dashboards.users-roles', ['tablink' => 'users', 'tab-button' => 'usersTabToggle']) }}"
                                                        class="dropdown-item"
                                                        style="{{ request()->routeIs('dashboards.users-roles') && request()->query('tablink') == 'users' ? 'color:gray' : '' }}">Users</a>
                                                </li>
                                            @endcan
                                            @can('view', App\Models\Role::class)
                                                <li class="ml-7">
                                                    <a href="{{ route('dashboards.users-roles', ['tablink' => 'roles', 'tab-button' => 'rolesTabToggle']) }}"
                                                        class="dropdown-item"
                                                        style="{{ request()->routeIs('dashboards.users-roles') && request()->query('tablink') == 'roles' ? 'color:gray' : '' }}">Roles</a>
                                                </li>
                                            @endcan
                                        @endcan
                                        <li class="mt-2 ml-3" style="font-weight: 700">
                                            <p>Order Status Links</p>
                                        </li>
                                        @can('create', App\Models\OrderStatus::class)
                                            <li class="ml-7">
                                                <a href="{{ route('user.order_statuses.create') }}" class="dropdown-item"
                                                    style="{{ request()->routeIs('user.order_statuses.create') ? 'color:gray' : '' }}">Create
                                                    An Order Status</a>
                                            </li>
                                        @endcan
                                        @can('update', App\Models\OrderStatus::class)
                                            <li class="ml-7">
                                                <a href="{{ route('user.order_statuses.edit_via_table') }}"
                                                    class="dropdown-item"
                                                    style="{{ request()->routeIs('user.order_statuses.edit_via_table') ? 'color:gray' : '' }}">Edit
                                                    Order Statuses Via Table</a>
                                            </li>
                                        @endcan
                                        <li class="mt-2 ml-3" style="font-weight: 700">
                                            <p>Prospect State Links</p>
                                        </li>
                                        @can('create', App\Models\ProspectState::class)
                                            <li class="ml-7">
                                                <a href="{{ route('user.prospect_states.create') }}" class="dropdown-item"
                                                    style="{{ request()->routeIs('user.prospect_states.create') ? 'color:gray' : '' }}">Create
                                                    A Prospect State</a>
                                            </li>
                                        @endcan
                                        @can('update', App\Models\ProspectState::class)
                                            <li class="ml-7">
                                                <a href="{{ route('user.prospect_states.edit_via_table') }}"
                                                    class="dropdown-item"
                                                    style="{{ request()->routeIs('user.prospect_states.edit_via_table') ? 'color:gray' : '' }}">Edit
                                                    Prospect States Via Table</a>
                                            </li>
                                        @endcan

                                        <li class="nav-item ml-1">
                                            <a class="nav-link" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            @can('prospects-products-orders-dashboard')
                                @can('view', App\Models\Product::class)
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="collapse" href="#productsMenu" role="button"
                                            aria-expanded="false" aria-controls="productsMenu">
                                            Products
                                        </a>
                                        <div class="collapse" id="productsMenu">
                                            <ul class="navbar-nav">
                                                <li class="nav-item ml-5">
                                                    <a href="{{ route('dashboards.prospects-products-orders', ['tablink' => 'products']) }}"
                                                        class="nav-link">Manage</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                @endcan

                                @can('view', App\Models\Prospect::class)
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="collapse" href="#prospectsMenu" role="button"
                                            aria-expanded="false" aria-controls="prospectsMenu">
                                            Prospects
                                        </a>
                                        <div class="collapse" id="prospectsMenu">
                                            <ul class="navbar-nav">
                                                <li class="nav-item ml-5">
                                                    <a href="{{ route('dashboards.prospects-products-orders', ['tablink' => 'prospects']) }}"
                                                        class="nav-link">Manage</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                @endcan

                                @can('view', App\Models\Order::class)
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="collapse" href="#ordersMenu" role="button"
                                            aria-expanded="false" aria-controls="ordersMenu">
                                            Orders
                                        </a>
                                        <div class="collapse" id="ordersMenu">
                                            <ul class="navbar-nav">
                                                <li class="nav-item ml-5">
                                                    <a href="{{ route('dashboards.prospects-products-orders', ['tablink' => 'orders']) }}"
                                                        class="nav-link">Manage</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                @endcan
                            @endcan
                        @endguest
                    </ul>

                </div>
            </div>
            <a href="#" onclick="window.history.back();"class="btn btn-light ml-5">Go Back</a>
            @yield('content')
        </main>
    </div>
</body>

</html>
