@extends('layouts.app')

@section('content')
<div class="container">

  @if (session('success'))
      <div class="alert alert-success">
        {{ session('success') }}
      </div>
  @endif

  <form method="GET" action="{{route('admin.prospects.dashboard')}}">
    <div class="input-group mb-3">
      <input type="text" class="form-control" name="search">
      <button class="input-group-text" type="submit">Search</button>
    </div>
    </form>
  <div class="card mt-4">
<div class="card-body">
  <div class="d-flex">
    <h2>Prospects <small class="text-muted">Showing All Prospects</small></h2>
    <div class="ml-auto" style="margin-left: auto">
    <div class="dropdown">
      <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
       Filter
      </button>
      <ul class="dropdown-menu">
        @foreach ($prospects as $prospect)              
        <form action="" method="GET">
          <li><button class="dropdown-item" name="search" id="search" type="submit" value="{{$prospect->state_id}} ">{{$prospect->prospectState}}</button>
          </form>
        @endforeach
      </ul>
    </div>
    </div>
    <div class="ml-auto" style="margin-left: auto">
      <div class="dropdown">
        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Actions
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="{{ route('admin.prospects.create') }}">Create New Prospect</a></li>
          <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>
  </div>
  
  @if ($prospects->count())
      @foreach ($prospects as $prospect)
          @include('admin.prospects.components.prospect-card', ['prospect' => $prospect])
      @endforeach
  @endif



</div>
@endsection