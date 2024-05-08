@extends('layouts.app')

@section('content')
<div class="container">

  <form method="GET" action="{{route('user.orders.dashboard')}}">
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
    <h2>Orders <small class="text-muted">Showing All Orders</small></h2>
    <div class="ml-auto" style="margin-left: auto">
    
    </div>
  </div>
</div>
  </div>
  
  @if ($orders->count())
  <div class="row">
    <div class="pt-4 d-flex flex-wrap justify-content-evenly">
  @foreach ($orders as $order)
          @include('user.orders.components.order-card', ['order' => $order])     
              @endforeach
            </div>
          </div>
          {{$orders->appends(request()->except('page'))->links()}}
  @endif
</div>
@endsection