@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="d-flex justify-content-center">
                    Create A New User
                </h2>
            </div>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="p-3">
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input class="form-control" type="text" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="role_id">Role</label>
                        <select name="role_id" id="" class="form-control">
                            @foreach (\App\Models\Role::all() as $role)
                                <option value="{{$role->id}}">{{$role->title}}</option>
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
