@extends('layouts.app')

@section('content')
<div class="container">

  @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
  @endif

  <div class="card mt-4">
<div class="card-body">
  <div class="d-flex">
    <h2>Products <small class="text-muted">Showing All Products</small></h2>
    <div class="ml-auto" style="margin-left: auto">
      <div class="dropdown">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Actions
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="{{ route('admin.products.create') }}">Create New Product</a></li>
          <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
  </div>
  
  @if ($products->count())
  <div class="row">
    <div class="pt-4 d-flex flex-wrap justify-content-evenly">
  @foreach ($products as $product)
          @include('admin.products.components.product-card', ['product' => $product])     
              @endforeach
            </div>
          </div>
  @endif
</div>
@endsection