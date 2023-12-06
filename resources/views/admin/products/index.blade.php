@extends('layouts.app')

@section('content')
<div class="container">
  <form method="GET" action="{{route('admin.products.dashboard')}}">
    <div class="input-group mb-3">
      <input type="text" class="form-control" name="search">
      <button class="input-group-text" type="submit">Search</button>
    </div>
    </form>

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
       Filter By Category
      </button>
      <ul class="dropdown-menu">
        @foreach ($categories as $category)
            <form action="#" method="GET">
              <li><button class="dropdown-item" name="filter_category" id="filter_category" type="submit" value="{{$category->id}}">{{$category->title}}</button>
              </form>
              @endforeach
        <form action="#" method="GET">
          <li><button class="dropdown-item" name="filter_category" id="filter_category" type="submit" value="all">All</button>
          </form>  
      </ul>
    </div>
    </div>
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