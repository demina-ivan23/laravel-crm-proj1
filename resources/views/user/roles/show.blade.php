@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="d-flex justify-content-center">
                     Role "{{$role->title}}"
                </h2>
            </div>

                <div class="p-3">
                    <div class="mb-3">
                        <label for="title">Title</label>
                        <div class="form-control">
                            <h4>
                                <strong>
                                    {{$role->title}}
                                </strong>
                            </h4>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description">Description</label>
                        <div class="form-control">
                            <h5>
                                    {{$role->description}}
                            </h5>
                        </div>
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
                                            value="{{ $permission->id }}" disabled {{$role->permissions->contains($permission->id) ? 'checked' : ''}}> {{ $permission->title }} 
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
