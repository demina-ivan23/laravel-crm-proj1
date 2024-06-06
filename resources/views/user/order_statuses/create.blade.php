@extends('layouts.app')

@section('content')
    <div class="container">
        <a href="{{ route('user.order_statuses.index') }}" class="btn btn-light">Go Back To Dashboard</a>
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
                                @can('view', \App\Models\OrderStatus::class)
                                    <li><a class="dropdown-item" href="{{ route('user.order_statuses.index') }}">All Order
                                            Statuses</a></li>
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
            <form action="{{ route('user.order_statuses.store') }}" method="POST">
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
                    <div class="mb-3" v-if="!statusIsFinal">
                        <label class="form-label" for="description">Can transit into</label>
                        @foreach (App\Models\OrderStatus::all() as $order_status)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $order_status->id }}"
                                    name="can_transit_into[]">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ $order_status->title }}
                                </label>
                            </div>
                        @endforeach
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
                    <div class="mb-3">
                        <label class="form-label" for="is_final">Is final</label>
                        <p>**If a status defined as final order with this status cannot transit to another status</p>
                        <select class="form-control" name="is_final" id="status_is_final" @input="changeStatusIsFinal">
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
