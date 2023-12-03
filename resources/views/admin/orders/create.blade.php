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
    <h2>Products To Order <small class="text-muted">Choose Products To Order</small></h2>
    <div class="ml-auto" style="margin-left: auto">
     
    </div>
  </div>
</div>
  </div>
  
  @if ($products->count())
  <div class="row">
      <form action="{{ route('admin.orders.store', ['prospect' => $prospect]) }}" method="POST">
        @csrf
    <div class="pt-4 d-flex flex-wrap justify-content-evenly">
  @foreach ($products as $product)
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

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="selected_products[]" value="{{$product->id}}" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                  Add To Cart
                </label>
              </div>
        </div>
      </div>
      @endforeach
    </div>
    <button class="btn btn-primary float-end mb-2" type="submit">Submit Order</button>
</form>
          </div>
  @endif
</div>
@endsection
