@extends('layouts.app')
@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <h4 class="d-flex justify-content-center">All Prospect States</h4>
        <div class="row">
            @if ($prospectStates->count())
                @foreach ($prospectStates as $prospectState)
                    @include('user.prospect_states.components.state-card')
                @endforeach
            @endif
        </div>
    </div>

@endsection
