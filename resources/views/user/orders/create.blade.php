@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('user.orders.create.select_products', ['prospect' => $prospect]) }}" class="btn btn-light">Go Back
            To Product Selection</a>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex">

                    <h2>Make An Order For {{ $prospect->name }}</h2>

                    <div class="ml-auto" style="margin-left: auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                @can('view', \App\Models\Order::class)
                                    <li><a class="dropdown-item"
                                            href="{{ route('dashboards.prospects-products-orders', ['tablink' => 'orders', 'tab-button' => 'ordersTabButton']) }}">Dashboard</a>
                                    </li>
                                @endcan
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            @if ($errors->count())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('user.orders.store', ['prospect' => $prospect]) }}" method="POST">
                @csrf
                <div class="p-3">
                    <div class="mb-3">
                        @php
                            use App\Services\OrderStatusService;
                            $first_step_statuses = OrderStatusService::getAllFSS();
                            $all_statuses = OrderStatusService::getAllOrderStatuses();
                        @endphp
                        <label class="form-label" for="order_status">Choose the status of the order</label>
                        <select name="order_status" id="order_status" class="form-control">
                            @foreach ($first_step_statuses as $order_status)
                                <option value="{{ $order_status->id }}">{{ $order_status->title }}</option>
                            @endforeach
                        </select>
                        <p style="font-size: 0.9em">If there are no statuses and/or no statuses are listed as FSS, ask your
                            Admin to add some.</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="explanation">Why this status?</label>
                        <input class="form-control" type="text" name="order_status_explanation"
                            id="order_status_explanation" placeholder="Write a short description">
                    </div>
                    <div class="mb-3">
                        <label for="default_order_transition" class="form-label">Choose a default order transition
                            status</label>
                        <select name="default_order_transition" id="default_order_transition" class="form-control">
                            <option value="{{ null }}">No status</option>
                            @foreach ($all_statuses as $order_status)
                                <option value="{{ $order_status->id }}">{{ $order_status->title }}</option>
                            @endforeach
                        </select>
                        <p style="font-size: 0.9em">The order will automaticaly transit to the chosen status if it reaches
                            it's expiery date. If no default transitoin status chosen, upon reaching it's expiery date, the
                            order will be
                            soft-deleted.</p>
                    </div>
                    <div class="mb-3">
                        <label for="expires_at" class="form-label">Expires at (by default it's not set; if you want to set
                            it, please type in date and time like this: YYYY-MM-DD hh:mm:ss) </label>
                        <input class="form-control" type="datetime" name="expires_at" id="expires_at">
                    </div>
                    <input type="hidden" name="selected_products_json" value="{{ request()['selected_products_json'] }}">
                    <div class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-primary" value="Submit Order">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
