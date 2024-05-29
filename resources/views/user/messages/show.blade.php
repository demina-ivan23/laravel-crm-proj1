@extends('layouts.app')
@section('content')
    @php
        $timezone = session('timezone') ?? 'UTC';
    @endphp
    <div class="container">
        <div class="d-flex justify-content-center align-items-center">
            <div class="mb-2 card p-3">
                <div class="mb-1">{{ $message->text }}</div>
                <div class="d-flex justify-content-end mb-1">
                    {{ \Carbon\Carbon::parse($message->created_at)->setTimezone($timezone)->format('M d, Y, H:i:s') }}
                </div>
            </div>
        </div>
    </div>
@endsection
