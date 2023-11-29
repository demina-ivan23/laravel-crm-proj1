@extends('layouts.app')

@section('content')
    <div class="card mt-4">
        <div class="card-body">
            <h2 class="d-flex justify-content-center">{{$prospect->name}}</h2>
            @include('admin.prospects.components.prospect-card', ['prospect' => $prospect])
        </div>
    </div>
@endsection
