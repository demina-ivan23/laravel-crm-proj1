@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if ($order_statuses->count())
                @foreach ($order_statuses as $order_status)
                    @include('superadmin.order_statuses.components.status-card')
                @endforeach
            @endif
        </div>
    @endsection
