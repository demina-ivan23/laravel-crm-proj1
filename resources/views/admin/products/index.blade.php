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
          {{-- @include('admin.products.components.product-card', ['product' => $product]); --}}
              <div class="card mb-5" style="width: 18rem;">
                @if ($product->product_image)
                    
                <img src="{{Storage::url($product->product_image)}}" alt="" >     
                @else
                <img src="/products/icons/box.png" alt="">
                @endif
                <div class="card-body">
                  <h5 class="card-title">{{$product->title}}</h5>
                  <p class="card-text">{{$product->description}}</p>
                </div>
                <ul class="list-group list-group-flush" id="card-items-container">
                  <li class="list-group-item" id="card-item-1">{{$product->price}}</li>
                </ul>
                <div class="card-body">
                  <ul>
                    <li>
                      <a href="#" class="card-link">View</a>
                    </li>
                    <li>
                      <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}" class="card-link">Edit </a>
                    </li>
                    <li>  <form action="{{ route('admin.products.destroy', ['product' => $product->id]) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                    </form>
                  </li>
                </ul>

                </div>
              </div>
              
              
              
              
              
              @endforeach
            </div>
          </div>
  @endif



</div>
@endsection