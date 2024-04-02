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
  
  <div class="row">
    <div class="col-sm-3">
      <div class="row" style="margin-top:60px; margin-right:5px">
        <div class="col-sm-12">
          <h4 class="ml-5 mb-10">Filters:</h4> 
        </div>
        <div class="ml-10 mb-10" id="price-filters">
          <div class="col-sm-12">
            <h5>Price filters:</h5>
          </div>
          <div class="col-sm-12">
            <input type="checkbox" name="price_filter" class="filter-checkbox" value="<10"> Price is less than $10 
            </div>
            <div class="col-sm-12">
              <input type="checkbox" name="price_filter" class="filter-checkbox" value="10-100"> Price is $10 to $100
            </div>
            <div class="col-sm-12">
              <input type="checkbox" name="price_filter" class="filter-checkbox" value="100-500"> Price is $100 to $500
            </div>
            <div class="col-sm-12">
              <input type="checkbox" name="price_filter" class="filter-checkbox" value="500-1000"> Price is $500 to $1000
            </div>
            <div class="col-sm-12">
              <input type="checkbox" name="price_filter" class="filter-checkbox" value="1000-5000"> Price is $1000 to $5000
            </div>
            <div class="col-sm-12">
              <input type="checkbox" name="price_filter" class="filter-checkbox" value=">5000"> Price is higher than $5000
            </div>
        </div>
        <div class="ml-10 mb-10" id="category-filters">
          <div class="col-sm-12">
            <h5>Category filters:</h5>
          </div>
          @foreach ($categories as $category)
          <div class="col-sm-12">
            <input type="checkbox" name="category_filter" value="{{$category->id}}" class="filter-checkbox"> {{$category->title}} 
          </div>
          @endforeach
          <div class="col-sm-12">
            <input type="checkbox" name="category_filter" value="none" class="filter-checkbox"> No category 
          </div>
        </div>
      </div>  
    </div>
    
    <div class="col-sm-9">
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
  </div>
  {{$products->appends(request()->except('page'))->links()}}
</div>
@endsection