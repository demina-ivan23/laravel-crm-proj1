@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="d-flex justify-content-center">
                    View User "{{ $user->name }}"
                </h2>
            </div>
            <div class="p-3">
                <div class="mb-3">
                    <h4>
                        Name:
                        {{ $user->name }}
                    </h4>
                </div>
                <div class="mb-3">
                    <h4>
                        Email:
                        {{ $user->email }}
                    </h4>
                </div>
                <div class="mb-3">
                    <h4>
                        Role:
                        {{ $user->role->title }}
                    </h4>
                </div>
                <div class="mb-3">
                    <h4>
                        Network status:
                        {{ $user->lastSeenOnline }}
                    </h4>
                </div>
                <div class="mb-3"></div>
            </div>
        </div>
    </div>
@endsection
