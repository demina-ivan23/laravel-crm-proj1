@extends('layouts.app')

@section('content')
<a href="{{route('admin.prospects.dashboard')}}" class="btn btn-light">Go Back To Prospects</a>
    <div class="card mt-4">
        <div class="card-body">
            <h2 class="d-flex justify-content-center">{{$prospect->name}}</h2>
            @include('admin.prospects.components.prospect-card', ['prospect' => $prospect])
        </div>
    </div>
@endsection
