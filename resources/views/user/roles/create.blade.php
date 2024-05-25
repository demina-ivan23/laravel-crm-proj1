@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="d-flex justify-content-center">
                    Create A User Role
                </h2>
            </div>

            <form action="{{ route('user.roles.store')}}" method="POST">
                @csrf
                <div class="p-3">
                    <div class="mb-3">
                        <label for="title">Title</label>
                        <input class="form-control" type="text" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="description">Description</label>
                        <input class="form-control" type="text" name="description">
                    </div>
                    <div class="mb-3">
                        <div class="mb-1">
                            <div class="row">
                                <label for="permissions[]">
                                    <h5>
                                        Permissions
                                    </h5>
                                </label>
                                @php
                                    $permissions = [];
                                    foreach (\App\Models\Permission::all() as $permission) {
                                        if ($permission->title !== 'be_untouchable') {
                                            $permissions[] = $permission;
                                        }
                                    } 
                                @endphp
                                @foreach ($permissions as $permission)
                                    <div class="col-sm-3">
                                        <input type="checkbox" name="permissions[]" id=""
                                            value="{{ $permission->id }}"> {{ $permission->title }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 d-flex justify-content-end">
                        <input class="btn btn-primary" type="submit" value="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
