@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-center align-items-center">
            <div class="mb-2 card p-3">
                <div class="mb-1">{{ $message->text }}</div>
                <div class="d-flex justify-content-end mb-1">
                    {{ $message->createdAtHumanized }}
                </div>
            </div>
        </div>
    </div>
@endsection