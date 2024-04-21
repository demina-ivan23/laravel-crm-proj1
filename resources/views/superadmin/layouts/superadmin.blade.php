@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="card">
                            <div class="card-body d-flex justify-content-center align-items-center">
                                <ul class="p-3">
                                    <li class="mt-2 d-flex justify-content-center">
                                        <h5>Links</h5>
                                    </li>
                                    <li class="mt-2 d-flex justify-content-center" style="font-weight: 700">
                                        <p>Main Superadmin Links</p>
                                    </li>
                                    <li class="mb-4">
                                        <a href="{{route('superadmin.index')}}" class="dropdown-item" style="{{ request()->routeIs('superadmin.index') ? 'color:blue' : '' }}">Superadmin Dashboard</a>
                                    </li>
                                    <li class="mt-2 d-flex justify-content-center" style="font-weight: 700">
                                        <p>Chart Links</p>
                                    </li>
                                    <li class="mb-4">
                                        <a href="{{route('superadmin.order_product_chart')}}" class="dropdown-item" style="{{ request()->routeIs('superadmin.order_product_chart') ? 'color:blue' : '' }}">Order-Product info page</a>
                                    </li>
                                    <li class="mb-4">
                                        <a href="{{route('superadmin.order_prospect_chart')}}" class="dropdown-item" style="{{ request()->routeIs('superadmin.order_prospect_chart') ? 'color:blue' : '' }}">Order-Prospect info page</a>
                                    </li>
                                    <li class="mt-2 d-flex justify-content-center" style="font-weight: 700">
                                        <p>Order Status Links</p>
                                    </li>
                                    <li class="mb-4">
                                        <a href="{{route('superadmin.order_statuses.index')}}" class="dropdown-item" style="{{ request()->routeIs('superadmin.order_statuses.index') ? 'color:blue' : '' }}">All Order Statuses</a>
                                    </li>
                                    <li class="mb-4">
                                        <a href="{{route('superadmin.order_statuses.create')}}" class="dropdown-item" style="{{ request()->routeIs('superadmin.order_statuses.create') ? 'color:blue' : '' }}">Create Order Status</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-10">
                                @yield('superadmin-content')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection