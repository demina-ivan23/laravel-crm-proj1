@extends('layouts.app')

@section('content')
    <div class="container">
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

                    <h2>Edit {{ ucfirst($order->customer->name) }}'s Order (Id: {{ $order->id }})</h2>

                    <div class="ml-auto" style="margin-left: auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('user.products.dashboard') }}">Dashboard</a>
                                </li>
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

            <form action="{{ route('user.orders.update', ['order' => $order]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-3">
                    <div class="mb-3">
                        @php
                            use App\Services\OrderStatusService;
                            $statuses = OrderStatusService::getAllOrderStatuses();
                            $current_status = $order->statuses()->latest()->first();
                        @endphp
                        <label class="form-label" for="order_status">Choose the status of the order</label>
                        <p>In edit mode you can choose only from statuses the status that your order is currently in can
                            allow transition into</p>
                        <select name="order_status" id="order_status" class="form-control">
                            @foreach ($statuses as $order_status)
                                @if ($current_status->statuses->contains($order_status) || $current_status->id === $order_status->id)
                                    <option value="{{ $order_status->id }}">{{ $order_status->title }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="explanation">Why this status?</label>
                        <input class="form-control" type="text" name="order_status_explanation"
                            id="order_status_explanation" placeholder="Write a short description"
                            value="{{ $current_status->pivot->explanation }}">
                    </div>
                    @if (!$current_status->is_final)
                        <div class="mb-3">
                            <label for="default_order_transition" class="form-label">Choose a default order transition
                                status</label>
                            <select name="default_order_transition" id="default_order_transition" class="form-control">
                                <option value="{{ null }}">No status</option>
                                @foreach ($statuses as $order_status)
                                    @if ($current_status->statuses->contains($order_status) || $current_status->id === $order_status->id)
                                        <option value="{{ $order_status->id }}">{{ $order_status->title }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <p style="font-size: 0.9em">The order will automaticaly transit to the chosen status if it
                                reaches
                                it's expiery date. If no default transitoin status chosen, upon reaching it's expiery date,
                                the
                                order will be
                                soft-deleted.</p>
                        </div>
                        <div class="mb-3">
                            <label for="expires_at" class="form-label">Expires at (by default it's not set; if you want to set it, please type in date and time like this: YYYY-MM-DD hh:mm:ss) </label>
                            <input class="form-control" type="datetime" name="expires_at" id="expires_at"
                                value="{{ $current_status->pivot->expires_at }}">
                        </div>
                    @else
                        <p>The status is final. The order is already closed with a status of "{{ $current_status->title }}"
                            at {{ $current_status->pivot->updated_at }} by UTC 0.</p>
                    @endif
                    <div class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </div>
            </form>


        </div>
    </div>
@endsection
