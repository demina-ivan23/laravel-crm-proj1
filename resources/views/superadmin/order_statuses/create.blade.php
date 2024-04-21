@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('superadmin.order_statuses.index') }}" class="btn btn-light">Go Back To Dashboard</a>
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex">

                    <h2>Create New Order Status</h2>

                    <div class="ml-auto" style="margin-left: auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('superadmin.order_statuses.index') }}">All Order
                                        Statuses</a></li>
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

            <form action="{{ route('superadmin.order_statuses.store') }}" method="POST">
                @csrf

                <div class="p-3">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input class="form-control" type="text" name="title" id="title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <input class="form-control" type="text" name="description" id="description">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Can transit into</label>
                        <input class="form-control" type="text" name="can_transit_into" id="can_transit_into">
                        <p>Please, type in titles of all statuses that an order with this status can transit to
                            <strong>
                                using "," as a separator.
                            </strong>
                            Please include only titles of existing statuses.
                            <strong>
                                Case sensitive.
                                Additional note:</strong> if this is one of the first statuses you create, do not type
                            anything in here.
                            Later, after you finish creating "empty" statuses, you can edit them to define
                            relationships between them
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="first_step_status">First step status</label>
                        <p> *First step status is a status that ryou can set as a first status for completely new order.
                            For example, for such statuses as "new", "pending", "potentially_fake" etc. Other statuses with
                            "No" value will not be available at the order creation, only at the order edition.</p>
                        <select class="form-control" name="first_step_status" id="first_step_status">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <button class="btn btn-primary float-end mb-2" type="submit">
                        Create
                    </button>

                </div>
            </form>


        </div>
    </div>
@endsection
