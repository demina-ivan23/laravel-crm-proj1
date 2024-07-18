@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center">
        @include('user.products.components.product-card', ['product' => $product])     
    </div>
</div>
@endsection