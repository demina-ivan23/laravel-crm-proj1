@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="d-flex justify-content-center">
                    Edit User "{{ $user->name }}"
                </h2>
            </div>
            <form action="{{ route('users.update', ['user' => $user]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="p-3">
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" name="name" value="{{ $user->name }}">
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email" value="{{ $user->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input class="form-control" type="text" name="password">
                    </div>
                    <div>
                        <label for="regenerate_api_key">Regenerate API key?</label>
                        <select name="regenerate_api_key" id="" class="form-control">
                            <option value="{{false}}">No</option>
                            <option value="{{true}}">Yes</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="role_id">Role</label>
                        <select name="role_id" id="" class="form-control">
                            <option value="{{ $user->role->id }}">{{ $user->role->title }}</option>
                            @foreach (\App\Models\Role::all() as $role)
                                @if ($role->id !== $user->role->id)
                                    <option value="{{ $role->id }}">{{ $role->title }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <input type="submit" class="btn btn-primary" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
