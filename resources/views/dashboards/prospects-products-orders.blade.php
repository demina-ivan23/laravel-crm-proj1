@extends('layouts.app')

@section('content')
    <div class="container">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('danger'))
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
        @endif
        @php
            $timezone = session('timezone') ?? 'UTC';
        @endphp
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                <li>
                    <button class="p-4 border-b-2 hover:text-blue-600 hover:border-blue-400 tab-button"
                        @click="togglePageTabs('prospects', 'prospectsTabToggle')" id="prospectsTabToggle">
                        <h5>
                            Prospects
                        </h5>
                    </button>
                </li>
                <li>
                    <button class="p-4 border-b-2 hover:text-blue-600 hover:border-blue-400 tab-button"
                        @click="togglePageTabs('products', 'productsTabToggle' )" id="productsTabToggle">
                        <h5>
                            Products
                        </h5>
                    </button>
                </li>
                <li>
                    <button class="p-4 border-b-2 hover:text-blue-600 hover:border-blue-400 tab-button"
                        @click="togglePageTabs('orders', 'ordersTabToggle' )" id="ordersTabToggle">
                        <h5>
                            Orders
                        </h5>
                    </button>
                </li>
            </ul>
        </div>
        @can('view', \App\Models\Prospect::class)
            <div class="hidden tablink" id="prospects">
                <form method="GET" action="{{ route('dashboards.prospects-products-orders', ['tablink' => 'prospects']) }}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="prospects-search"
                            value="{{ request('prospects-search') }}">
                        <button class="input-group-text" type="submit">Search</button>
                    </div>
                </form>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2>Prospects <small class="text-muted">Showing All Prospects</small></h2>
                            <div class="ml-auto" style="margin-left: auto">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Filter By State
                                    </button>
                                    <ul class="dropdown-menu">
                                        @foreach ($states as $state)
                                            <form
                                                action="{{ route('dashboards.prospects-products-orders', ['tablink' => 'prospects']) }}"
                                                method="GET">
                                                <li><button class="dropdown-item" name="filter_state" id="filter_state"
                                                        type="submit" value="{{ $state->id }}">{{ $state->title }}</button>
                                            </form>
                                        @endforeach
                                        <form
                                            action="{{ route('dashboards.prospects-products-orders', ['tablink' => 'prospects']) }}"
                                            method="GET">
                                            <li><button class="dropdown-item" name="filter_state" id="filter_state"
                                                    type="submit" value="all">All</button>
                                        </form>
                                    </ul>
                                </div>
                            </div>
                            <div class="ml-auto" style="margin-left: auto">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        @can('create', \App\Models\Prospect::class)
                                            <li><a class="dropdown-item" href="{{ route('user.prospects.create') }}">Create New
                                                    Prospect</a></li>
                                        @endcan
                                        <li><a class="dropdown-item"
                                                href="{{ route('dashboards.prospects-products-orders', ['prospectsWithTrashed' => true]) }}">Show
                                                With Trashed</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('dashboards.prospects-products-orders', ['prospectsOnlyTrashed' => true]) }}">Show
                                                Only Trashed</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('dashboards.prospects-products-orders') }}">Show Without
                                                Trashed</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($prospects->count())
                    <table class="p-4 table mt-5 mb-5">
                        <thead>
                            <th>
                                <h4>
                                    <strong>
                                        Name
                                    </strong>
                                </h4>
                            </th>
                            <th>
                                <h4>
                                    <strong>
                                        Email
                                    </strong>
                                </h4>
                            </th>
                            <th>
                                <h4>
                                    <strong>
                                        Additional info
                                    </strong>
                                </h4>
                            </th>
                            <th>
                                <h4>
                                    <strong>
                                        Actions
                                    </strong>
                                </h4>
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($prospects as $prospect)
                                <tr>
                                    <th>
                                        <h5>{{ $prospect->name }}</h5>
                                    </th>
                                    <th>
                                        <h5>
                                            {{ $prospect->email }}
                                        </h5>
                                    </th>
                                    <th>
                                        <ul>
                                            @if ($prospect->phone_number !== null)
                                                <li>
                                                    <strong>Phone Number: </strong> {{ $prospect->phone_number }}
                                                </li>
                                            @endif
                                            @if ($prospect->address !== null)
                                                <li>
                                                    <strong>Address: </strong> {{ $prospect->address }}
                                                </li>
                                            @endif
                                        </ul>
                                    </th>
                                    <th>
                                        <div class="dropdown d-flex justify-content-center">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item"
                                                        href="{{ route('user.prospects.show', ['prospect' => $prospect]) }}">View
                                                        "{{ $prospect->name }}"</a></li>
                                                @can('update', $prospect)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('user.prospects.edit', ['prospect' => $prospect]) }}">Edit</a>
                                                    </li>
                                                @endcan
                                                @can('create', \App\Models\Order::class)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('user.orders.create.select_products', ['prospect' => $prospect]) }}">Make
                                                            An Order For "{{ $prospect->name }}"</a></li>
                                                @endcan
                                                @can('view', \App\Models\Order::class)
                                                    <li><a class="dropdown-item"
                                                            href="{{ route('user.prospects.show-orders', ['prospect' => $prospect]) }}">View
                                                            Orders Of "{{ $prospect->name }}"</a></li>
                                                @endcan
                                                @if (!$prospect->deleted_at)
                                                    @can('update', $prospect)
                                                        <li>
                                                            <form class="dropdown-item"
                                                                action="{{ route('user.prospects.delete', ['prospect' => $prospect]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endcan
                                                @else
                                                    @can('update', $prospect)
                                                        <li>
                                                            <form class="dropdown-item"
                                                                action="{{ route('user.prospects.restore', ['prospect' => $prospect]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit">
                                                                    Restore
                                                                </button>
                                                            </form>
                                                        </li>
                                                    @endcan
                                                @endif
                                                @can('delete', $prospect)
                                                    <li>
                                                        <form
                                                            action="{{ route('user.prospects.destroy', ['prospect' => $prospect]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item"
                                                                onclick="return confirm('Are you sure you want to delete this prospect? This action will also delete all info about the prospect, including order info.')">Delete
                                                                Permanently</button>
                                                        </form>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </div>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="d-flex justify-content-center">
                        There are no prospects that correspond to the applied filters yet
                    </p>
                @endif
                {{ $prospects->appends(request()->except('page'))->links() }}
            </div>
        @endcan
        @cannot('view', \App\Models\Prospect::class)
            <p class="d-flex justify-content-center">
                You don't have enough rights
            </p>
        @endcannot
        @can('view', \App\Models\Product::class)
            <div class="hidden tablink" id="products">
                <form method="GET" action="{{route('dashboards.prospects-products-orders', ['tablink' => 'products'])}}">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="products-search" value="{{request('products-search')}}">
                        <button class="input-group-text" type="submit">Search</button>
                    </div>
                </form>
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2>Products <small class="text-muted">Showing All Products</small></h2>
                            <div class="ml-auto" style="margin-left: auto">

                            </div>
                            <div class="ml-auto" style="margin-left: auto">

                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        @can('create', \App\Models\Product::class)
                                            <li><a class="dropdown-item" href="{{ route('user.products.create') }}">Create
                                                    New
                                                    Product</a></li>
                                        @endcan
                                        <li><a class="dropdown-item"
                                                href="{{ route('dashboards.prospects-products-orders', ['tablink' => 'products', 'productsWithTrashed' => true]) }}">Show
                                                With Trashed</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('dashboards.prospects-products-orders', ['tablink' => 'products', 'productsOnlyTrashed' => true]) }}">Show
                                                Only Trashed</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('dashboards.prospects-products-orders', ['tablink' => 'products']) }}">Show
                                                Without Trashed</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2">
                        <div class="row" style="margin-top:60px; margin-right:5px">
                            <div class="col-sm-12">
                                <h4 class="ml-5 mb-10">Filters:</h4>
                            </div>
                            <div class="ml-10 mb-10" id="price-filters">
                                <div class="col-sm-12">
                                    <h5>Price filters:</h5>
                                </div>
                                <div class="col-sm-12">
                                    <input type="checkbox" name="products_price_filter" class="filter-checkbox"
                                        value="<10">
                                    Price
                                    is less than $10
                                </div>
                                <div class="col-sm-12">
                                    <input type="checkbox" name="products_price_filter" class="filter-checkbox"
                                        value="10-100">
                                    Price
                                    is $10 to $100
                                </div>
                                <div class="col-sm-12">
                                    <input type="checkbox" name="products_price_filter" class="filter-checkbox"
                                        value="100-500">
                                    Price is $100 to $500
                                </div>
                                <div class="col-sm-12">
                                    <input type="checkbox" name="products_price_filter" class="filter-checkbox"
                                        value="500-1000">
                                    Price is $500 to $1000
                                </div>
                                <div class="col-sm-12">
                                    <input type="checkbox" name="products_price_filter" class="filter-checkbox"
                                        value="1000-5000">
                                    Price is $1000 to $5000
                                </div>
                                <div class="col-sm-12">
                                    <input type="checkbox" name="products_price_filter" class="filter-checkbox"
                                        value=">5000">
                                    Price
                                    is higher than $5000
                                </div>
                            </div>
                            <div class="ml-10 mb-10" id="products_category_filters">
                                <div class="col-sm-12">
                                    <h5>Category filters:</h5>
                                </div>
                                @foreach ($categories as $category)
                                    <div class="col-sm-12">
                                        <input type="checkbox" name="products_category_filters" value="{{ $category->id }}"
                                            class="filter-checkbox"> {{ $category->title }}
                                    </div>
                                @endforeach
                                <div class="col-sm-12">
                                    <input type="checkbox" name="products_category_filters" value="none"
                                        class="filter-checkbox"> No
                                    category
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($products->count())
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="pt-4 d-flex flex-wrap justify-content-evenly">
                                    @foreach ($products as $product)
                                        @include('user.products.components.product-card', [
                                            'product' => $product,
                                        ])
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-10">
                            <div class="d-flex justify-content-center mt-4">
                                <h3>
                                    No products found by the filtering criterias
                                </h3>
                            </div>
                        </div>
                    @endif
                </div>
                {{ $products->appends(request()->except('page'))->links() }}
            </div>
        @endcan
        @cannot('view', \App\Models\Product::class)
            <p class="hidden d-flex justify-content-center tablink" id="products">
                You don't have enough rights to read products
            </p>
        @endcannot
        @can('view', \App\Models\Order::class)
            <div class="hidden tablink" id="orders">
                <form method="GET" action="#">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="orders-search">
                        <button class="input-group-text" type="submit">Search</button>
                    </div>
                </form>

                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-flex">
                            <h2>Orders <small class="text-muted">Showing All Orders</small></h2>
                            <div class="ml-auto" style="margin-left: auto">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Filter By Status
                                    </button>
                                    <ul class="dropdown-menu">
                                        @foreach ($statuses as $status)
                                            <form action="#" method="GET">
                                                <li><button class="dropdown-item" name="filter__order_status"
                                                        id="filter__order_status" type="submit"
                                                        value="{{ $status->id }}">{{ $status->title }}</button>
                                            </form>
                                        @endforeach
                                        <form action="#" method="GET">
                                            <li><button class="dropdown-item" name="filter__order_status"
                                                    id="filter__order_status" type="submit" value="all">All</button>
                                        </form>
                                    </ul>
                                </div>
                            </div>
                            <div class="ml-auto" style="margin-left: auto">

                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item"
                                                href="{{ route('dashboards.prospects-products-orders', ['tablink' => 'orders', 'ordersWithTrashed' => true]) }}">Show
                                                With Trashed</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('dashboards.prospects-products-orders', ['tablink' => 'orders', 'ordersOnlyTrashed' => true]) }}">Show
                                                Only Trashed</a></li>
                                        <li><a class="dropdown-item"
                                                href="{{ route('dashboards.prospects-products-orders', ['tablink' => 'orders']) }}">Show
                                                Without Trashed</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($orders->count())
                    <table class="p-4 table mt-5 mb-5">
                        <thead>
                            <th>
                                <h4><strong>Id</strong></h4>
                            </th>
                            <th>
                                <h4><strong>Customer</strong></h4>
                            </th>
                            <th>
                                <h4><strong>Products</strong></h4>
                            </th>
                            <th>
                                <h4><strong>Order</strong></h4>
                            </th>
                            <th>
                                <h4><strong>Actions</strong></h4>
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <th>
                                        <h5>{{ $order->id }}</h5>
                                    </th>
                                    <th>
                                        <p>Name: {{ $order->customer->name }}</p>
                                        <p>Email: {{ $order->customer->email }}</p>
                                    </th>
                                    <th>
                                        <p>
                                            @php
                                                $productsString = '';
                                            @endphp
                                            @foreach ($order->products()->limit(3)->get() as $product)
                                                @php
                                                    $productsString .= $product->title . ', ';
                                                @endphp
                                            @endforeach
                                            {{ substr($productsString, 0, strlen($productsString) - 2) . ' ' }}
                                            @if ($order->products->count() > 3)
                                                and more
                                            @endif
                                            @if ($order->products->count() == 0)
                                                {{ $productsString = 'all the products were permanently deleted or an unexpected error occurred' }}
                                            @endif
                                    </th>
                                    </p>
                                    <th>
                                        <p>Order's current status:
                                            {{ $order->statuses()->latest()->first()->title }}</p>
                                        <p>Order created at:
                                            {{ \Carbon\Carbon::parse($order->created_at)->setTimezone($timezone)->format('M d, Y, H:i:s') }}
                                        </p>
                                        @if ($order->statuses()->latest()->first()->is_final)
                                            <p>Order closed at:
                                                {{ \Carbon\Carbon::parse($order->latestStatus->pivot->created_at)->setTimezone($timezone)->format('M d, Y, H:i:s') }}
                                            </p>
                                        @endif
                                    </th>
                                    <th>

                                        <div class="dropdown">
                                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                @can('view', $order->customer)
                                                    <a href="{{ route('user.prospects.show', ['prospect' => $order->customer]) }}"
                                                        class="dropdown-item justify-center">View
                                                        "{{ $order->customer->name }}"</a>
                                                @endcan
                                                <a href="{{ route('user.orders.show', ['order' => $order]) }}"
                                                    class="dropdown-item justify-center">View
                                                    this order</a>
                                                @can('update', $order)
                                                    <a href="{{ route('user.orders.edit', ['order' => $order]) }}"
                                                        class="dropdown-item justify-center">Edit
                                                        this order</a>
                                                @endcan
                                                @if (!$order->deleted_at)
                                                    @can('delete', $order)
                                                        <form action="{{ route('user.orders.delete', ['order' => $order]) }}"
                                                            method="POST" class="dropdown-item justify-center">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit">Move To Trash</button>
                                                        </form>
                                                    @endcan
                                                @else
                                                    @can('restore', $order)
                                                        <form action="{{ route('user.orders.restore', ['order' => $order]) }}"
                                                            method="POST" class="dropdown-item justify-center">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit">Restore</button>
                                                        </form>
                                                    @endcan
                                                @endif
                                                @can('forceDelete', $order)
                                                    <form action="{{ route('user.orders.destroy', ['order' => $order]) }}"
                                                        method="POST" class="dropdown-item justify-center">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit">Delete Permanently</button>
                                                    </form>
                                                @endcan
                                            </ul>
                                        </div>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="hiden d-flex justify-content-center tablink" id="orders">
                        There are no orders that correspond to the applied filters yet
                    </p>
                @endif
                {{ $orders->appends(request()->except('page'))->links() }}
            </div>
        @endcan
        @cannot('view', \App\Models\Order::class)
            <p class="hiden d-flex justify-content-center tablink" id="orders">
                You don't have enough rights
            </p>
        @endcannot

    </div>
@endsection
