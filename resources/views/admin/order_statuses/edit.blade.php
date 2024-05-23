@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <a href="{{ route('admin.order_statuses.index') }}" class="btn btn-light">Go Back To Dashboard</a>
        <div class="card mt-4">
            <div class="card-body">
                <div class="d-flex">

                    <h2>Edit "{{ $orderStatus->title }}"</h2>

                    <div class="ml-auto" style="margin-left: auto">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.order_statuses.index') }}">All Order
                                        Statuses</a></li>
                                <li><a class="dropdown-item" href="{{ route('admin.order_statuses.create') }}">Create A
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
            <form action="{{ route('admin.order_statuses.update', ['order_status' => $orderStatus]) }}"
                method="POST">
                @csrf
                @method('PUT')
                <div class="p-3">
                    <div class="mb-3">
                        <label class="form-label" for="title">Title</label>
                        <input class="form-control" type="text" name="title" id="title"
                            value="{{ $orderStatus->title }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="description">Description</label>
                        <input class="form-control" type="text" name="description" id="description"
                            value="{{ $orderStatus->description }}">
                    </div>
                    <div class="mb-3" v-if="!statusIsFinal">
                        <label class="form-label" for="description">Can transit into</label>
                        @foreach (App\Models\OrderStatus::all()->except($orderStatus->id) as $other_order_status)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $other_order_status->id }}"
                                    name="can_transit_into[]"
                                    {{ $orderStatus->statuses->contains($other_order_status->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ $other_order_status->title }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="first_step_status">First step status</label>
                        <p> *First step status is a status that you can set as a first status for completely new order.
                            For example, for such statuses as "new", "pending", "potentially_fake" etc. Other statuses with
                            "No" value will not be available at the order creation, only at the order edition.</p>
                        <select class="form-control" name="first_step_status" id="first_step_status">
                            @if ($orderStatus->first_step_status)
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            @else
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="is_final">Is final</label>
                        <p>**If a status defined as final order with this status cannot transit to another status</p>
                        <select class="form-control" name="is_final" id="status_is_final" @input="changeStatusIsFinal">
                            @if ($orderStatus->is_final)
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
