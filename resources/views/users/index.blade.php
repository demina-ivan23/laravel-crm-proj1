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
        <div class="card mt-4">
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <h4>
                                <strong>
                                    Name
                                </strong>
                            </h4>
                        </th>
                        <th>
                            <h4>
                                <strong>
                                    Email
                                </strong>
                            </h4>
                        </th>
                        <th>
                            <h4>
                                <strong>
                                    Network status
                                </strong>
                            </h4>
                        </th>
                        <th>
                            <h4>
                                <strong>
                                    Actions
                                </strong>
                            </h4>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <th>
                                <h5>
                                    {{ $user->name }}
                                </h5>
                            </th>
                            <th>
                                <h5>
                                    {{ $user->email }}
                                </h5>
                            </th>
                            <th>
                                <h5 class="d-flex justify-content-center">
                                    {{ $user->lastSeenOnline }}
                                </h5>
                            </th>
                            <th>
                                <div class="d-flex justify-content-evenly">
                                    <a href="{{ route('users.show', ['user' => $user]) }}" class="btn btn-secondary">View</a>
                                    <a href="{{ route('users.edit', ['user' => $user]) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('users.delete', ['user' => $user]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-danger" value="Delete">
                                    </form>
                                </div>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
