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
        <div class="row">
            @if ($roles->count())
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <h5>
                                    <strong>Title</strong>
                                </h5>
                            </th>
                            <th>
                                <h5>
                                    <strong>Permissions</strong>
                                </h5>
                            </th>
                            <th>
                                <h5>
                                    <strong>Actions</strong>
                                </h5>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <th>
                                    <h5>
                                        <strong>{{ $role->title }}</strong>
                                    </h5>
                                </th>
                                <th>
                                    @if ($role->permissions->count())
                                        @foreach ($role->permissions()->limit(3)->get() as $permission)
                                            {{ $permission->title . ', ' }}
                                        @endforeach
                                        @if ($role->permissions->count() > 3)
                                            and more
                                        @endif
                                    @else
                                        No permissions yet
                                    @endif
                                </th>
                                <th>
                                    <div class="d-flex justify-content-evenly">
                                        <a class="btn btn-secondary mr-4 pt-1 pb-1"
                                            href="{{ route('user.roles.show', ['role' => $role]) }}">View</a>
                                        <a class="btn btn-primary mr-4 pt-1 pb-1"
                                            href="{{ route('user.roles.edit', ['role' => $role]) }}">Edit</a>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <h2 class="d-flex justify-content-center">
                    No roles that would fulfill the requirements of the applied filters yet. Create new roles or ask a
                    person with a proper permissions to do it
                </h2>
            @endif
        </div>
    </div>
@endsection
