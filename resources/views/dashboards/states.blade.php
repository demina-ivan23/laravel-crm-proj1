@extends('layouts.app')
@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h2 class="d-flex justify-content-center mb-5">States Dashboard</h2>

        <div class="mb-2 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                <li>
                    <button class="p-4 border-b-2 hover:text-blue-600 hover:border-blue-400 tab-button"
                        @click="togglePageTabs('prospectStates', 'prospectStatesTabToggle')" id="prospectStatesTabToggle">
                        <h5>
                            Prospect States
                        </h5>
                    </button>
                </li>
                <li>
                    <button class="p-4 border-b-2 hover:text-blue-600 hover:border-blue-400 tab-button"
                        @click="togglePageTabs('orderStatuses', 'orderStatusesTabToggle')" id="orderStatusesTabToggle">
                        <h5>
                            Order Statuses
                        </h5>
                    </button>
                </li>
            </ul>
        </div>
        @can('view', \App\Models\ProspectState::class)
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 tablink" id="prospectStates">
                @can('create', \App\Models\ProspectState::class)
                    <div class="d-flex justify-content-end mr-10 mb-4">
                        <a href="{{ route('user.prospect_states.create') }}">
                            <img src="/web_icons/plus.png" alt="plus icon" width="20" height="20">
                        </a>
                    </div>
                @endcan
                @if ($prospectStates->count())
                    <table class="table">
                        <thead>
                            <th>
                                <h4>
                                    <strong>
                                        Title
                                    </strong>
                                </h4>
                            </th>
                            <th>
                                <h4>
                                    <strong>
                                        Description
                                    </strong>
                                </h4>
                            </th>
                            <th>
                                <h4>
                                    <strong>
                                        Transits to
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
                            @foreach ($prospectStates as $prospectState)
                                <tr>
                                    <th>
                                        <h5>
                                            {{ $prospectState->title }}
                                        </h5>
                                    </th>
                                    <th>
                                        <h5>
                                            {{ strlen($prospectState->description) > 40 ? substr($prospectState->description, 0, 40) . '...' : $prospectState->description }}
                                        </h5>
                                    </th>
                                    <th>
                                        <h5>
                                            @if ($prospectState->states()->count())
                                                @php
                                                    $statesString = '';
                                                @endphp
                                                @foreach ($prospectState->states()->limit(3)->get() as $state)
                                                    @php
                                                        $statesString .= $state->title . ', ';
                                                    @endphp
                                                @endforeach
                                                {{ substr($statesString, 0, strlen($statesString) - 2) . ' ' }}
                                                @if ($prospectState->states()->count() > 3)
                                                    and more
                                                @endif
                                            @else
                                                Nothing yet.
                                            @endif
                                        </h5>
                                    </th>
                                    <th>
                                        @can('update', $prospectState)
                                            <a class="btn btn-primary"
                                                href="{{ route('user.prospect_states.edit', ['prospect_state' => $prospectState]) }}">
                                                Edit
                                            </a>
                                        @endcan
                                        @cannot('update', $prospectState)
                                            <p class="d-flex justify-content-center">
                                                You don't have enough rights
                                            </p>
                                        @endcannot
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="hidden d-flex justify-content-center tablink" id="prospectStates">
                        There are no prospect states that correspond to the applied filters yet
                    </p>
                @endif
                {{ $prospectStates->appends(request()->except('page'))->links() }}

            </div>
        @endcan
        @cannot('view', \App\Models\ProspectState::class)
            <p class="hidden d-flex justify-content-center tablink" id="prospectStates">
                You don't have enough rights to read prospect states
            </p>
        @endcannot
        @can('view', \App\Models\OrderStatus::class)
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 tablink" id="orderStatuses">
                @can('create', \App\Models\OrderStatus::class)
                    <div class="d-flex justify-content-end mr-10 mb-4">
                        <a href="{{ route('user.order_statuses.create') }}">
                            <img src="/web_icons/plus.png" alt="plus icon" width="20" height="20">
                        </a>
                    </div>
                @endcan
                @if ($orderStatuses->count())
                    <table class="table">
                        <thead>
                            <th>
                                <h4>
                                    <strong>
                                        Title
                                    </strong>
                                </h4>
                            </th>
                            <th>
                                <h4>
                                    <strong>
                                        Description
                                    </strong>
                                </h4>
                            </th>
                            <th>
                                <h4>
                                    <strong>
                                        Transits to
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
                            @foreach ($orderStatuses as $orderStatus)
                                <tr>
                                    <th>
                                        <h5>
                                            {{ $orderStatus->title }}
                                        </h5>
                                    </th>
                                    <th>
                                        <h5>
                                            {{ strlen($orderStatus->description) > 40 ? substr($orderStatus->description, 0, 40) . '...' : $orderStatus->description }}

                                        </h5>
                                    </th>
                                    <th>
                                        <h5>
                                            @if ($orderStatus->statuses()->count())
                                                @php
                                                    $statusesString = '';
                                                @endphp
                                                @foreach ($orderStatus->statuses()->limit(3)->get() as $status)
                                                    @php
                                                        $statusesString .= $status->title . ', ';
                                                    @endphp
                                                @endforeach
                                                {{ substr($statusesString, 0, strlen($statusesString) - 2) . ' ' }}
                                                @if ($orderStatus->statuses()->count() > 3)
                                                    and more
                                                @endif
                                            @else
                                                Nothing yet.
                                            @endif
                                        </h5>
                                    </th>
                                    <th class="d-flex justify-content-evenly">
                                        @can('update', $orderStatus)
                                            <a class="btn btn-primary "
                                                href="{{ route('user.order_statuses.edit', ['order_status' => $orderStatus]) }}">
                                                Edit
                                            </a>
                                            <form
                                                action="{{ route('user.order_statuses.update', ['order_status' => $orderStatus]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                @if ($orderStatus->first_step_status)
                                                    <input type="hidden" name="first_step_status" id="first_step_status"
                                                        value="0">
                                                    <input type="submit" class="btn btn-danger" value="Disable FSS"
                                                        title="FSS - first step status (for order creation). You can have multiple FSSs">
                                                @else
                                                    <input type="hidden" name="first_step_status" id="first_step_status"
                                                        value="1">
                                                    <input type="submit" class="btn btn-success" value="Enable FSS"
                                                        title="FSS - first step status (for order creation). You can have multiple FSSs">
                                                @endif
                                            </form>
                                        @endcan
                                        @cannot('update', $orderStatus)
                                            You can't update this order status
                                        @endcannot
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="hidden d-flex justify-content-center tablink" id="orderStatuses">
                        There are no order statuses that correspond to the applied filters yet
                    </p>
                @endif
                {{ $orderStatuses->appends(request()->except('page'))->links() }}
            </div>
        @endcan
        @cannot('view', \App\Models\OrderStatus::class)
            <p class="hidden d-flex justify-content-center tablink" id="orderStatuses">
                You don't have enough rights to read order statuses
            </p>
        @endcannot
    </div>

@endsection
