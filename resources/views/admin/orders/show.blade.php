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
        <div class="card mt-2">

            <div class="card-body">
                <div class="d-flex">
                    <h2>View The {{ ucfirst($order->customer->name) }}'s Order With The Id Of {{ $order->id }}</h2>
                </div>
            </div>
            <hr>
            <div class="p-3">
                {{-- Orders Id, Order created at, Customer's name, email; last transittion's description; current status, whether tis' final or not, expires_at if not; Order closed at; Order's history of transitions; --}}

                <div class="mb-3 form-control">Order's Id: {{ $order->id }}</div>
                <div class="mb-3 form-control">Order created at: {{ $order->created_at }} (GMT +0)</div>
                <div class="mb-3 form-control">Prospect's name: {{ $order->customer->name }}</div>
                <div class="mb-3 form-control">Prospect's email: {{ $order->customer->email }}</div>
                @if ($order->statuses()->latest()->first()->pivot->explanation)
                    <div class="mb-3 form-control">Explanation of the last transition:
                        {{ $order->statuses()->latest()->first()->pivot->explanation }}</div>
                @endif
                <div class="mb-3 form-control">Current status: {{ $order->statuses()->latest()->first()->title }}</div>
                @if ($order->statuses()->latest()->first()->is_final)
                    <div class="mb-3 form-control">The status of the order is final, the order is closed at:
                        <p class="card-text">{{ $order->statuses()->latest()->first()->pivot->created_at }} by
                            GMT+0
                        </p>
                    </div>
                @else
                    <div class="mb-3 form-control">The status transition of the order is not final
                        @if ($order->statuses()->latest()->first()->pivot->expires_at)
                            , it expires at {{ $order->statuses()->latest()->first()->pivot->expires_at }}
                        @endif
                    </div>
                @endif
                <div class="mb-3 form-control">
                  <label for="order_history_table" class="form-label d-flex justify-content-center"><h4>Order's Status Transition History</h4></label>
                    <div class="relative overflow-x-auto" name="order_history_table">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Status title
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Explanation
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Created at/Updated at
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Expire(-s/-d) at
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($order->statuses as $status)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{$i}}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $status->title }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $status->pivot->explanation }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $status->pivot->created_at }} / {{ $status->pivot->updated_at }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $status->pivot->expires_at ?? 'without an expiration date' }}
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
