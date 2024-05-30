<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //Users can only view their profiles, whereas other methods are accessible for admins only 

    public function index()
    {
        return view('users.index', ['users' => User::withTrashed()->latest()->filter()->paginate(10), 'roles' => Role::withTrashed()->latest()->filter()->paginate(10)]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $user = UserService::storeUser($request->all());
        if (!$user) {
            return redirect()->route('users.dashboard')->with('error', 'Something went wrong');
        }
        return redirect()->route('users.dashboard')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->all();
        $success = UserService::updateUser($user, $data);
        if (!$success) {
            return redirect()->route('users.dashboard')->with('error', 'Something went wrong');
        } else {
            return redirect()->route('users.dashboard')->with('success', 'User updated successfully');
        }
    }

    public function delete(User $user)
    {
        //Only soft-deleting should be in action here
        $user->delete();
        return redirect()->route('users.dashboard')->with('success', 'User trashed successfully');
    }

    //Because we use soft deletes we need one more method for restoing the user
    public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('users.dashboard')->with('success', 'User restored successfully');
    }

    // Because we have separate permissions for users to perform actions
    // on themselves and on others, we have to define these separate methods
    public function showSelf()
    {
        return view('users.show', ['user' => auth()->user()]);
    }
    public function editSelf()
    {
        return view('users.edit', ['user' => auth()->user()]);
    }
    public function updateSelf(Request $request){
        $data = $request->all();
        $success = UserService::updateUser(auth()->user(), $data);
        if (!$success) {
            return redirect()->route('users.dashboard')->with('error', 'Something went wrong');
        } else {
            return redirect()->route('users.dashboard')->with('success', 'User updated successfully');
        }
    }
}
