@extends('layouts.app')
@section('content')
    <div class="container">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card mt-2">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    @php
                        $explodedStr = explode('\\', $messages[0]->messagable_type);
                        $modelName = $explodedStr[count($explodedStr) - 1];

                        if ($modelName[0] == ('O' || 'A' || 'I' || 'E')) {
                            $a = 'an';
                        } else {
                            $a = 'a';
                        }
                        // $a is just a joke but it works well)
                    @endphp
                    <h2>All messages for {{ $a }} {{ $modelName }} with the Id of
                        {{ $messages[0]->messagable_id }}</h2>
                </div>
            </div>
            @if ($messages->count())
                <div class="m-2">

                    @foreach ($messages as $message)
                        <div class="mb-2 card p-2">
                            <div class="d-flex justify-content-end mb-1">
                                {{ $message->createdAtHumanized }}
                            </div>
                            <div class="mb-1">{{ $message->text }}</div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('user.messages.show', ['message' => $message]) }}"
                                    class="btn btn-primary">View this message</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <h5 class="d-flex justify-content-center">No messages... yet.</h5>
            @endif
        </div>
    </div>
@endsection
