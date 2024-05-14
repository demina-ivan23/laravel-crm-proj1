@extends('layouts.app')

@section('content')
<div class="container">
    <a class="btn btn-light"href="{{route('user.products.dashboard')}}">Go To Products</a>
    <div class="d-flex justify-content-center">
        @include('user.products.components.product-card', ['product' => $product])     
    </div>
</div>
@endsection