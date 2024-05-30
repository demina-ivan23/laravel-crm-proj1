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
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="-tab"
                data-tabs-toggle="#default-tab-content" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="roles-tab" data-tabs-target="#roles"
                        type="button" role="tab" aria-controls="roles" aria-selected="false">Roles</button>
                </li>
                <li class="me-2" role="presentation">
                    <button
                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                        id="users-tab" data-tabs-target="#users" type="button" role="tab" aria-controls="users"
                        aria-selected="false">Users</button>
                </li>
            </ul>
        </div>
        <div id="default-tab-content">
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="roles" role="tabpanel"
            aria-labelledby="roles-tab">
        </div>
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="users" role="tabpanel"
            aria-labelledby="users-tab">
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
                                    @if ($user->deleted_at)
                                        <form action="{{ route('users.restore', ['user' => $user]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="submit" class="btn btn-success" value="Restore">
                                        </form>
                                    @else
                                        <a href="{{ route('users.show', ['user' => $user]) }}"
                                            class="btn btn-secondary">View</a>
                                        <a href="{{ route('users.edit', ['user' => $user]) }}"
                                            class="btn btn-primary">Edit</a>
                                        <form action="{{ route('users.delete', ['user' => $user]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" class="btn btn-danger" value="Delete">
                                        </form>
                                    @endif
                                </div>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection
