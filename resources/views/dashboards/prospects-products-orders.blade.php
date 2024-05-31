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

        <div class="hidden tablink" id="prospects">
            <form method="GET" action="#">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="prospects-search">
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
                                        <form action="#" method="GET">
                                            <li><button class="dropdown-item" name="filter_state" id="filter_state"
                                                    type="submit" value="{{ $state->id }}">{{ $state->title }}</button>
                                        </form>
                                    @endforeach
                                    <form action="#" method="GET">
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
                                    <li><a class="dropdown-item" href="{{ route('user.prospects.create') }}">Create New
                                            Prospect</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
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
                                            <li><a class="dropdown-item"
                                                    href="{{ route('user.prospects.edit', ['prospect' => $prospect]) }}">Edit</a>
                                            </li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('user.orders.create.select_products', ['prospect' => $prospect]) }}">Make
                                                    An Order For "{{ $prospect->name }}"</a></li>
                                            <li><a class="dropdown-item"
                                                    href="{{ route('user.prospects.show-orders', ['prospect' => $prospect]) }}">View
                                                    Orders Of "{{ $prospect->name }}"</a></li>
                                            <li>
                                                <form
                                                    action="{{ route('user.prospects.destroy', ['prospect' => $prospect]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item"
                                                        onclick="return confirm('Are you sure you want to delete this prospect?')">Delete</button>
                                                </form>
                                            </li>

                                        </ul>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $prospects->appends(request()->except('page'))->links() }}
            @endif
        </div>
        <div class="hidden tablink" id="products">
            <form method="GET" action="#">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="products-search">
                    <button class="input-group-text" type="submit">Search</button>
                </div>
            </form>
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex">
                        <h2>Products <small class="text-muted">Showing All Products</small></h2>
                        <div class="ml-auto" style="margin-left: auto">

                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Filter By Category
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach ($categories as $category)
                                        <form action="#" method="GET">
                                            <li><button class="dropdown-item" name="filter_category" id="filter_category"
                                                    type="submit"
                                                    value="{{ $category->id }}">{{ $category->title }}</button>
                                        </form>
                                    @endforeach
                                    <form action="#" method="GET">
                                        <li><button class="dropdown-item" name="filter_category" id="filter_category"
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
                                    <li><a class="dropdown-item" href="{{ route('user.products.create') }}">Create New
                                            Product</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
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
                                <input type="checkbox" name="price_filter" class="filter-checkbox" value="<10"> Price
                                is less than $10
                            </div>
                            <div class="col-sm-12">
                                <input type="checkbox" name="price_filter" class="filter-checkbox" value="10-100"> Price
                                is $10 to $100
                            </div>
                            <div class="col-sm-12">
                                <input type="checkbox" name="price_filter" class="filter-checkbox" value="100-500">
                                Price is $100 to $500
                            </div>
                            <div class="col-sm-12">
                                <input type="checkbox" name="price_filter" class="filter-checkbox" value="500-1000">
                                Price is $500 to $1000
                            </div>
                            <div class="col-sm-12">
                                <input type="checkbox" name="price_filter" class="filter-checkbox" value="1000-5000">
                                Price is $1000 to $5000
                            </div>
                            <div class="col-sm-12">
                                <input type="checkbox" name="price_filter" class="filter-checkbox" value=">5000"> Price
                                is higher than $5000
                            </div>
                        </div>
                        <div class="ml-10 mb-10" id="category-filters">
                            <div class="col-sm-12">
                                <h5>Category filters:</h5>
                            </div>
                            @foreach ($categories as $category)
                                <div class="col-sm-12">
                                    <input type="checkbox" name="category_filter" value="{{ $category->id }}"
                                        class="filter-checkbox"> {{ $category->title }}
                                </div>
                            @endforeach
                            <div class="col-sm-12">
                                <input type="checkbox" name="category_filter" value="none" class="filter-checkbox"> No
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
                    @else
                        <div class="d-flex justify-content-center mt-4">
                            <h3>
                                No products found by the filtering criterias
                            </h3>
                        </div>
                @endif
            </div>
        </div>
        {{ $products->appends(request()->except('page'))->links() }}
    </div>

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
                                        <a href="{{ route('user.prospects.show', ['prospect' => $order->customer]) }}"
                                            class="dropdown-item justify-center">View "{{ $order->customer->name }}"</a>
                                        <a href="{{ route('user.orders.show', ['order' => $order]) }}"
                                            class="dropdown-item justify-center">View
                                            this order</a>
                                        <a href="{{ route('user.orders.edit', ['order' => $order]) }}"
                                            class="dropdown-item justify-center">Edit
                                            this order</a>
                                    </ul>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->appends(request()->except('page'))->links() }}
        @endif
    </div>


    </div>
@endsection
