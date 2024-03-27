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
    <h2>Orders <small class="text-muted">Showing Orders Related To "{{$prospect->name}}"</small></h2>
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
          {{$orders->appends(request()->except('page'))->links()}}
  @else
  <div class="row">
    <div class="pt-4 d-flex flex-wrap justify-content-evenly">
      <h4>This Prospect Has No Orders Yet</h4>
    </div>
  </div>
  @endif
</div>
@endsection