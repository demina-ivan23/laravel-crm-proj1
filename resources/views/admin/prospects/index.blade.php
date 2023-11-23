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
    <h2>Prospects <small class="text-muted">Showing All Prospects</small></h2>
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