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
        <h2 class="d-flex justify-content-center mb-5">
            Users And Roles Dashboard
        </h2>
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                <li>
                    <button class="p-4 border-b-2 hover:text-blue-600 hover:border-blue-400 tab-button"
                        @click="togglePageTabs('users', 'usersTabToggle')" id="usersTabToggle">
                        <h5>
                            Users
                        </h5>
                    </button>
                </li>
                <li>
                    <button class="p-4 border-b-2 hover:text-blue-600 hover:border-blue-400 tab-button"
                        @click="togglePageTabs('roles', 'rolesTabToggle' )" id="rolesTabToggle">
                        <h5>
                            Roles
                        </h5>
                    </button>
                </li>
            </ul>
        </div>

        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 tablink" id="users">
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
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 tablink" id="roles">
            <div class="row">
                @if ($roles->count())
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <h4>
                                        <strong>Title</strong>
                                    </h4>
                                </th>
                                <th>
                                    <h4>
                                        <strong>Permissions</strong>
                                    </h4>
                                </th>
                                <th>
                                    <h4>
                                        <strong>Actions</strong>
                                    </h4>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <th>
                                        <h5>
                                            {{ $role->title }}
                                        </h5>
                                    </th>
                                    <th>
                                        <h5>
                                            @if ($role->permissions->count())
                                                @php
                                                    $permissionsString = '';
                                                @endphp
                                                @foreach ($role->permissions()->limit(3)->get() as $permission)
                                                    @php
                                                        $permissionsString .= $permission->title . ', ';
                                                    @endphp
                                                @endforeach
                                                {{ substr($permissionsString, 0, strlen($permissionsString) - 2) . ' ' }}
                                                @if ($role->permissions->count() > 3)
                                                    and more
                                                @endif
                                            @else
                                                No permissions yet
                                            @endif
                                        </h5>
                                    </th>
                                    <th>
                                        @if (!\App\Models\Role::onlyTrashed()->find($role->id))
                                            <div class="d-flex justify-content-evenly">
                                                <a class="btn btn-secondary mr-4 pt-1 pb-1"
                                                    href="{{ route('user.roles.show', ['role' => $role]) }}">View</a>
                                                <a class="btn btn-primary mr-4 pt-1 pb-1"
                                                    href="{{ route('user.roles.edit', ['role' => $role]) }}">Edit</a>
                                                <form action="{{ route('user.roles.delete', ['role' => $role]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input class="btn btn-danger" type="submit" value="Delete">
                                                </form>
                                            </div>
                                        @else
                                            <form action="{{ route('user.roles.restore', ['role' => $role]) }}"
                                                method="POST">
                                                @csrf
                                                @method('put')
                                                <input class="btn btn-success" type="submit" value="Restore">
                                            </form>
                                        @endif
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
    </div>
    </div>
@endsection
