@extends('layouts.app')
@section('content')
<div class="container">
            <h4 class="d-flex justify-content-center">All Prospect States</h4>
    <div class="row">
        @if ($prospectStates->count())
        @foreach ($prospectStates as $prospectState)
        @include('admin.prospect_states.components.state-card')
        @endforeach
        @endif
    </div>
</div>
    
@endsection