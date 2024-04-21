@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <a href="{{ route('superadmin.order_statuses.index') }}" class="btn btn-light">Go Back To Dashboard</a>
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex">

                    <h2>Edit "{{ $order_status->title }}"</h2>

                    <div class="ml-auto" style="margin-left: auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('superadmin.order_statuses.index') }}">All Order
                                        Statuses</a></li>
                                <li><a class="dropdown-item" href="{{ route('superadmin.order_statuses.create') }}">Create A
                                        New Order Status</a></li>
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
            <form action="{{ route('superadmin.order_statuses.update', ['order_status' => $order_status]) }}"
                method="POST">
                @csrf
                @method('PUT')
                <div class="p-3">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input class="form-control" type="text" name="title" id="title"
                            value="{{ $order_status->title }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <input class="form-control" type="text" name="description" id="description"
                            value="{{ $order_status->description }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Can transit into</label>
                        <input class="form-control" type="text" name="can_transit_into" id="can_transit_into"
                            value="{{ $order_status->can_transit_into }}">
                        <p>Please, type in titles of all statuses that an order with this status can transit to
                            <strong>
                                using "," as a separator.
                            </strong>
                            Please include only titles of existing statuses.
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="first_step_status">First step status</label>
                        <p> *First step status is a status that you can set as a first status for completely new order.
                            For example, for such statuses as "new", "pending", "potentially_fake" etc. Other statuses with
                            "No" value will not be available at the order creation, only at the order edition.</p>
                        <select class="form-control" name="first_step_status" id="first_step_status">
                            @if ($order_status->first_step_status)
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            @else
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            @endif
                        </select>
                    </div>
                    <button class="btn btn-primary float-end mb-2" type="submit">
                        Submit changes
                    </button>

                </div>
            </form>
        </div>
    </div>
@endsection
