@extends('layouts.app')

@section('content')
    <div class="container">
        @php
            $timezone = session('timezone') ?? 'UTC';
        @endphp
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex">
                    <h2>Orders <small class="text-muted">Showing Orders Related To "{{ $prospect->name }}"</small></h2>
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
                                    </ul>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $orders->appends(request()->except('page'))->links() }}
        @else
            <div class="row">
                <div class="pt-4 d-flex flex-wrap justify-content-evenly">
                    <h4>This Prospect Has No Orders Yet</h4>
                </div>
            </div>
        @endif
    </div>
@endsection
