@extends('layouts.app')

@section('content')
<div class="container">
    <a class="btn btn-light"href="{{route('admin.products.dashboard')}}">Go Back To Products</a>
    <div class="d-flex justify-content-center">
        @include('admin.products.components.product-card', ['product' => $product])     
    </div>
</div>
@endsection