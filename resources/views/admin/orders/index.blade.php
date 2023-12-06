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
          @include('admin.orders.components.order-card', ['order' => $order])     
              @endforeach
            </div>
          </div>
  @endif
</div>
@endsection